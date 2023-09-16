<?php

namespace App\Http\Controllers\PaymentGateways;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Payment;
use App\Mail\PlaceOrder;
use App\Models\Admin\Order;
use Stripe\PaymentIntent;
use Stripe\Stripe;


class StripeController extends Controller
{
    public function __construct()
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    protected $t = 0;

    public function index(Request $request)
    {

        $order = DB::table('orders')->where('id', $request->order)->first();
        
        $data['total'] = $order->total;
        $this->t = $order->total;
        //session(['amount'=>$data['total']]);
        session(['OID'=>$order->id]);
        $data['gateway_name'] = 'stripe';
        $data['publishable_key'] = env('STRIPE_KEY');

        $total = intval($this->convertToCent(session('amount')));
        //return $total;// gettype(intval(session('amount')));
        return view('user.checkout.index', compact('data','order'));
    }



    public function capturePayment(Request $request)
    {
        $intent = null;

        $total = intval($this->convertToCent(session('total_amount')));
        try {
            if (isset($request->payment_method_id)) {
                # Create the PaymentIntent
                $intent = PaymentIntent::create([
                    'payment_method' => $request->payment_method_id,
                    'amount' => $total,
                    'currency' => currency(),
                    'confirmation_method' => 'manual',
					'return_url' => 'https://portal.myperfectwriting.co.uk/user/pay_now?id='.session('OID'),
                    'confirm' => true,
                ]);
            }
            if (isset($request->payment_intent_id)) {
                $intent = PaymentIntent::retrieve(
                    $request->payment_intent_id
                );
                $intent->confirm();
            }
            $res = $this->generateResponse($intent);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            # Display error on client
            $res = [
                'error' => $e->getMessage(),
            ];
        }

        //session()->forget('total_amount');
        return response()->json($res);
    }



public function generateResponse($intent)
{
    try {
        # Note that if your API version is before 2019-02-11, 'requires_action'
        # appears as 'requires_source_action'.
        if (($intent->status == 'requires_action' || $intent->status == 'requires_source_action') &&
            $intent->next_action->type == 'use_stripe_sdk'
        ) {
            # Tell the client side to handle the action
            return [
                'requires_action' => true,
                'payment_intent_client_secret' => $intent->client_secret,
            ];
        } else if ($intent->status == 'succeeded') {
            # The payment didn’t need any additional actions and completed!
            # Handle post-payment fulfillment
			
			
			$array = array(
				"type" => "order-placed",
				"name" => auth()->user()->username,
				"email" =>auth()->user()->email,
				"subject" => "Order Placed",
				"sender" => auth()->user()->username,
				"country" => auth()->user()->country,
				"message" => "Order has been placed, successfully",
				"action" => "Action Required"
			);
			$jsonObject = json_encode($array);
			
			DB::table('notifications')->insert([
				'id' => rand(00000,99999),
				'type' => 'order-placed',
				'notifiable_type'=> 'App\Models\User',
				'notifiable_id' => 1,
				'data' => $jsonObject,'created_at'=>date('Y-m-d h:i:s')

			]);
			
			DB::table('notifications')->insert([
				'id' => rand(00000,99999),
				'type' => 'App\Notifications\GeneralNotification',
				'notifiable_type'=> 'App\Models\User',
				
				'notifiable_id' => auth()->user()->id,
				'data' => $jsonObject,'created_at'=>date('Y-m-d h:i:s')

			]);
			
            $token = $this->savePaymentRecords(session('total_amount'), $intent->id);
			$user = auth()->user();
			$order = Order::where('id', session('OID'))->first();
            Mail::to(request('email'))->cc($user->email)->send(new Payment($user, $order));
			
			sleep(3);
			
			Mail::to(request('email'))->cc(auth()->user()->email)->send(new PlaceOrder($user, $order->id));
			
			
            return [
                "success" => true,
                'redirect_url' => $this->urltoRedirectOnSuccess($token)
            ];
        } else {
            # Invalid status
            return ['error' => 'Could not process your payment'];
        }
    } catch (\Exception $e) {
        # Handle any exceptions that occur during the payment process
        return ['error' => $e->getMessage()];
    }
}


    private function urlToRedirectOnSuccess($token)
    {
        // Generate the URL to redirect on successful payment
        toastr()->success(__('Payment has been successfully proccessed'));

        return route('payment.success');
    }

    public function success()
    {
		session()->forget('total_amount');
        return view('user.checkout.success');
    }

    protected function savePaymentRecords($amount, $transactionReference)
    {
             
        $this->store(auth()->user()->id , 'Stripe', $amount, $transactionReference);

        // Mark in the cart that payment has been made
        $payment_unique_identifier = bin2hex(random_bytes(5));
        //$this->cart->setPaymentComplete($amount, $payment_unique_identifier);

        return $payment_unique_identifier;
    }

    protected function store($payerUserId, $paymetMethod, $amount, $transactionReference, $attachment = null)
    {
       
        $payment = DB::table('payments')->insert([
            'user_id' => $payerUserId,
            'order_id' => session('OID'),
            'price' => $amount,
            'currency' => currency(),
            'gateway' => 'Stripe',
			'status' => 'completed',
            
        ]);
		
		 DB::table('orders')->where('id', session('OID'))->update([
           'payment_status' => 1,
        ]);
        //$payment->from->wallet()->deposit($payment->amount, $payment);

        return $payment;
    }

    private function convertToCent($amount)
    {
        // Stripe accepts the amount as cents only.
        return intval($amount * 100);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;
use App\Mail\InCompletePayment;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;

class LocaleController extends Controller
{
     public function __construct()
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function language(Request $request, string $language)
    {
        try {
            if (array_key_exists($language, config('locale'))) {
                Session::put('locale', $language);
                App::setLocale($language);
                return redirect()->back();
            }
            return redirect('/');
        } catch (\Exception $exception) {
            return redirect('/');
        }
    }
	
	public function paymentOfOrder($id)
	 {
	 	session()->forget('OID');
        $order = DB::table('orders')->where('id', $id)->first();
        $comments = DB::table('comments')->where('order_id', $order->id)->get();
		$attachments =  DB::table('attachments')->where('order_id', $order->id)->get();
        return view('paymentOfOrder', compact('order', 'comments','attachments'));
	 }
	
	public function success()
	 {
	 	return view('success');
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
			$name = '';
			$email = '';
			$country = '';
			if(auth()->user()){
				$name = auth()->user()->username;
				$email = auth()->user()->email;
				$country = auth()->user()->country;
			} else {
				$name = 'admin';
				$email = 'admin@example.com';
				$country = 'admin';
			} 
			$array = array(
				"type" => "order-placed",
				"name" => $name,
				"email" =>$email,
				"subject" => "Order Placed",
				"country" => $country,
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
			
            $token = $this->savePaymentRecords(session('total_amount'), $intent->id);
        
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

        return route('success');
    }



    protected function savePaymentRecords($amount, $transactionReference)
    {
             if(auth()->user()){
        $this->store(auth()->user()->id , 'Stripe', $amount, $transactionReference);
			 } else {
			 	     $this->store(1, 'Stripe', $amount, $transactionReference);
			 }
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
	
	public function cron () {
		

$today = now()->toDateString();

$order = DB::table('orders')->where('payment_status', 0)->where('icpes',0)->whereDate('created_at', '>=', $today)->orderBy('id', 'DESC')->first();if($order){
		//oreach($orders as $o) {
			$user = DB::table('users')->where('id',$order->customer_id)->first(); 
			//$order = DB::table('orders')->where()->first();echo $user->username. $o->id;
		
			Mail::to(request('email'))->cc($user->email)->send(new InCompletePayment($user, $order));
			DB::table('orders')->where('payment_status', 0)->where('icpes',0)->where('id',$order->id)->update(['icpes'=>1]);
		
		return 'emails has been sent to users whom have not completed their payment process yet';} else { return 'no incomplete payment process';}
		
	}
}

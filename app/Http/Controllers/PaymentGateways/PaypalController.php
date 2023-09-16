<?php

namespace App\Http\Controllers\PaymentGateways;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Payment;
use App\Mail\PlaceOrder;
use App\Models\Admin\Order;

class PaypalController extends Controller
{
      private $client;

    public function __construct()
    {
        //parent::__construct('paypal_checkout');

        $this->client = new PayPalHttpClient($this->environment());
    }

   

    public function generateToken(Request $request)
    {
		$total = session('total_amount');
        $orderRequest = new OrdersCreateRequest();
        $orderRequest->body = [
            "intent" => "CAPTURE",

            "purchase_units" => [
                [
                    "amount" => [
                        "value" => $total,
                        "currency_code" => currency(),
                    ],
                                
                ],
                     ],

        ];

        $error = null;
        try {
            // Call API with your client and get a response for your call
            $response = (object) $this->client->execute($orderRequest);

            if ($this->isTokenGenerationSuccessful($response)) {
                return response()->json([
                    'status' => 'success',
                    'id' => $response->result->id,
                ]);
            }
        } catch (\PayPalHttp\HttpException | \Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            $this->logError($error, 'While generating token');
        }

        return response()->json([
            'status' => 'failure',
            'message' => 'Please try again later, or use a different payment method',
        ]);
    }

    public function capturePayment(Request $request)
    {
      

        $request = new OrdersCaptureRequest($request->order_id);
        // $request->prefer('return=representation');
        $error = null;

        try {

            $response = (object) $this->client->execute($request);

            if ($this->isCaptureSuccessful($response)) {

                // Record the Payment Information
                $token = $this->savePaymentRecords($this->getCapturedAmount($response), $response->result->id);
				$user = auth()->user();
				$order = Order::where('id', session('OID'))->first();
            	Mail::to(request('email'))->cc($user->email)->send(new Payment($user, $order));
				sleep(3); 
				Mail::to(request('email'))->cc(auth()->user()->email)->send(new PlaceOrder($user, $order_id));
				
                return redirect()->route('payment.success');
            }
        } catch (\PayPalHttp\HttpException | \Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            $this->logError($error, 'While capturing payment');
        }

        return redirect()->back();
    }

    private function getCapturedAmount($response)
    {
        return $response->result->purchase_units[0]->payments->captures[0]->amount->value;
    }
    private function isTokenGenerationSuccessful($response)
    {
        if (isset($response->result->status) && $response->result->status == 'CREATED' && isset($response->result->id) && $response->result->id) {
            return true;
        }
    }

    private function isCaptureSuccessful($response)
    {
        if (isset($response->result->status) && $response->result->status == 'COMPLETED' && isset($response->result->id) && $response->result->id) {
            return true;
        }
    }

    private function environment()
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_SECRET');

        return new ProductionEnvironment($clientId, $clientSecret);
    }
	
	
	   protected function savePaymentRecords($amount, $transactionReference)
    {
             
        $this->store(auth()->user()->id , 'PayPal', $amount, $transactionReference);

        // Mark in the cart that payment has been made
        $payment_unique_identifier = bin2hex(random_bytes(5));
        //$this->cart->setPaymentComplete($amount, $payment_unique_identifier);

        return $payment_unique_identifier;
    }

    private function urlToRedirectOnSuccess($token)
    {
        // Generate the URL to redirect on successful payment
        toastr()->success(__('Payment has been successfully proccessed'));

        return route('payment.success');
    }

    protected function store($payerUserId, $paymetMethod, $amount, $transactionReference, $attachment = null)
    {
        $payments = DB::table('payments')->count();
        $number = $payments;
        $number += 1;
        $payment = DB::table('payments')->insert([
            'user_id' => $payerUserId,
            'order_id' => session('OID'),
            'price' => $amount,
            'currency' => currency(),
            'gateway' => 'Paypal',
			'status' => 'completed',
        ]);
      	 DB::table('orders')->where('id', session('OID'))->update([
           'payment_status' => 1,
        ]);

        return $payment;
    }
	
	  protected function logError($error, $when)
    {
        Log::debug('payment_gateway_error', [
            'user_id' => auth()->user()->id,
            'gateway' => 'Paypal',
            'when'  => $when,
            'message' => $error
        ]);
     
    }
}

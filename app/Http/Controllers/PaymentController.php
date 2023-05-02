<?php

namespace App\Http\Controllers;

use AdamStipak\Webpay\Api;
use AdamStipak\Webpay\Exception;
use AdamStipak\Webpay\PaymentRequest;
use AdamStipak\Webpay\PaymentResponse;
use AdamStipak\Webpay\PaymentResponseException;
use AdamStipak\Webpay\Signer;
use AdamStipak\Webpay\SignerException;
use App\Events\CreditAdded;
use App\Models\Payment;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function initPaymentApi()
    {
        try {
            $signer = new Signer(
                env('PRIVATE_KEY_PATH'),
                env('PRIVATE_KEY_PASWORD'),
                env('PUBLIC_KEY_PATH')
            );
        } catch (SignerException $e) {
            dd($e->getMessage());
        }

        return new Api(
            env('MERCHANT_NUMBER'),
            env('WEBPAY_URL'),
            $signer
        );
    }

    public function createPaymentLink($amount)
    {
        // Request:
        $orderNumber = timeInMilis() . rand(1, 999);
        $currency = env('CURRENCY'); // ?
        $depositFlag = 1;
        $url = route('payments.payment-link.confirmation');
        $merOrderNumber = null; // nevim
        $md = null; // nevim
        $addInfo = null; // nevim

        $request = new PaymentRequest($orderNumber, $amount, $currency, $depositFlag, $url, $merOrderNumber, $md, $addInfo);

        $api = $this->initPaymentApi();

        $url = $api->createPaymentRequestUrl($request); // $api instance of \AdamStipak\Webpay\Api

        return [
            'url' => $url,
            'digest' => $orderNumber
        ];
    }

    public function verifyPaymentResponse(Request $request)
    {
        $req = $request->all();

        $operation = $req['OPERATION'];
        $orderNumber = $req['ORDERNUMBER'];
        $merOrderNumber = null;
        $prcode = $req['PRCODE'];
        $srcode = $req['SRCODE'];
        $resultText = $req['RESULTTEXT'];
        $digest = $req['DIGEST'];
        $digest1 = $req['DIGEST1'];
        $md = null; // custom data

        $response = new PaymentResponse($operation, $orderNumber, $merOrderNumber, $prcode, $srcode, $resultText, $digest, $digest1, $md); // fill response with response parameters (from request).

        try {
            $api = $this->initPaymentApi();
            $api->verifyPaymentResponse($response);

            $payment = Payment::where('digest', '=', $response->getParams()['ordermumber'])
                ->where('status', '=', 'waiting')
                ->first();

            if (!$payment) return redirect()->to(route('credits.index'));

            $plan = $payment->plan;

            $credits_to_add = $plan->credits + $plan->extra;
            $credit = $payment->user->credit;
            $credit->increment('amount', $credits_to_add);
            $credit->expiration_date = Carbon::now()->add($plan->length . 'months');
            $credit->save();

            $payment->status = 'success';
            $payment->save();

            event(new CreditAdded($credit, $credits_to_add));

            return view('payments.create')->with([
                'payment' => $payment,
                'plan' => $payment->plan
            ]);

        } catch (PaymentResponseException $e) {
            // PaymentResponseException has $prCode, $srCode for properties for logging GP Webpay response error codes.
            return view('payments.error')->with([
                'message' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            // Digest is not correct.
            return view('payments.error')->with([
                'message' => $e->getMessage()
            ]);
        }

    }

    public function create(Plan $plan, Request $request)
    {
        if ($plan) {
            $payment_link = $this->createPaymentLink($plan->price);

            Payment::create([
                'plan_id' => $plan->id,
                'user_id' => $request->user()->id,
                'status' => 'waiting',
                'digest' => $payment_link['digest'],
            ]);

            header('Location: ' . $payment_link['url']);
            exit();
        }

        abort(404);
        return false;
    }
}

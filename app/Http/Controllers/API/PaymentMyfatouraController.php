<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\PaymentMyfatoura;
use App\Models\Cart;
use App\Models\Order;

class PaymentMyfatouraController extends Controller
{
    public $apiURL = "https://api-sa.myfatoorah.com/";
    public $apiToken = "MT19_nmb7xrsTMxJmWlw5Q1AZ_t5cx1Om1Ad8gPH7EyngTCg51rdUvxUkWlEOteAsylQrSVvUO3NtlvUbbdKMxSdy_MVXVECqdPz8anSBebIJ33fBCm3ClpyCUyiooi7u4YKm7z-if-TKcy4xcALSARQHDPPizJsLV--CbCxNkrinEfV_C8oL0D2fWCeDRNOTk_CVEPEiDr_gCz59uo4yUfb734Ul119yOHfHO4qaF6_oF4kVZyJF2e0JpmH2jtYZzv8KZzlxJ6ZES3d3TEm2qBw48wnX5zU7lRbyOxS3X7yrAnkfu3iZKLeH_riar99Pa303hjFRS2yA-_xp8l1zsZSOYe-f62arSJpk7U0IFihzKw0dV1oUPGA8NbiobsajNjBiRIz_GSW3k-4gGkLBB0R1Pv4xXzk37Ej2O4oDA2vaIhbakHMyUi3nFNBs9Ob5SpzrmpreNu0XZWdA1On-gnBRJ9VH8XBdxAqzdnGlDXDkV4uHOqB9hi_eAymNc34Z7m1nrxAeh7OgUZeWi0uk7hHdz4GDNoH1z6XTu0C4IHhqQg6eXuBsE4uJ1Tvt1GaWQGmYzfiqvYiPTliZ3t7X-o0ZnSmWcepY466Dv2MKYPNgO3M7Ex60v88tN5XtADiBkI4oRi7szJw5gIYTaan2XbX6HUOYOYFplRrnTXMtFlYoFtHN58wGNX8vCEkBkToCxtl7Q";

    public function index(Request $request)
    {

        $data = [

            'NotificationOption' => 'LNK',
            'CustomerName' => $request->customer_name,
            'CurrencyIso' => 'SAR',
            'MobileCountryCode' => '+966',
            'CustomerMobile' => $request->phone,
            'CustomerEmail' => $request->email,
            'InvoiceValue' => $request->amount,
            'InvoiceAmount' => $request->amount,
            'CallBackUrl' => url('api/v1/payment/myfatoura/callback'),
            'ErrorUrl' => url('api/v1/payment/myfatoura/error'),
            'Language' => 'ar',
            'CustomerReference' => $request->user_id,
            'CustomerCivilId' => $request->cart_id ? $request->cart_id : '',
            'UserDefinedField' => $request->branch_id ? $request->branch_id : '',
            'ExpireDate' => '',
        ];

        $response = Http::withToken($this->apiToken)->post("https://api-sa.myfatoorah.com/v2/SendPayment", $data);
        $paymentURL = $response->json('Data');
        if ($response->successful() && $response->json('IsSuccess')) {
            //return redirect()->away($paymentURL);
            return response(['message' => $paymentURL]);
        }
        return response()->json(['error'=>$request->customer_name]);
        
    }


    public function callback(Request $request)
    {
        try {
            $response = Http::withToken($this->apiToken)->post("https://api-sa.myfatoorah.com/v2/getPaymentStatus", [
                'Key' => $request->paymentId,
                'KeyType' => 'PaymentId',
            ]);
            PaymentMyfatoura::create([
                'user_id'                   => $response->json('Data')["CustomerReference"],
                // 'order_id'                   => $response->json('Data')["UserDefinedField"],
                'invoice_id'                => $response->json('Data')["InvoiceId"],
                'invoice_status'            => $response->json('Data')["InvoiceStatus"],
                'invoice_reference'         => $response->json('Data')["InvoiceReference"],
                'created_date'              => $response->json('Data')["CreatedDate"],
                'comments'                  => $response->json('Data')["Comments"],
                'invoice_display_value'     => $response->json('Data')["InvoiceDisplayValue"],
                'payment_gateway'           => $response->json('Data')["InvoiceTransactions"][0]["PaymentGateway"],
                'transaction_id'            => $response->json('Data')["InvoiceTransactions"][0]["TransactionId"],
                'transaction_status'        => $response->json('Data')["InvoiceTransactions"][0]["TransactionStatus"],
                'paid_currency'             => $response->json('Data')["InvoiceTransactions"][0]["PaidCurrency"],
                'paid_currency_value'       => $response->json('Data')["InvoiceTransactions"][0]["PaidCurrencyValue"],
                'card_number'               => $response->json('Data')["InvoiceTransactions"][0]["CardNumber"],
                'is_success'                => 1,
            ]);
            $user = $response->json('Data')["CustomerReference"];
            $cart = Cart::where('owner_id',$user)->first();
            return redirect()->away('https://baytalhummus.com/orders/success?branch='.$response->json('Data')["UserDefinedField"].'&cart='.$cart->id.'&shop='.$cart->shop_id);
            
            // if(!empty($cart)){
            //     $response = Http::withToken($user->apiToken)->post('https://backend.alqandeelaldahabi.com/api/v1/dashboard/user/orders', [
            //         'currency_id' => $cart->currency_id,
            //         'rate' => $cart->rate,
            //         'shop_id' => $cart->shop_id,
            //         'cart_id' => $cart->id,
            //         'payment_type' => 'MyFatoorah',
            //     ]);
            //     if ($response->successful()) {
            //         $cart->delete();
            //         return redirect()->away('https://alqandeelaldahabi.com/orders/'.$order_id);
            //     } 
                
            // }else{
            //     return redirect()->away('https://alqandeelaldahabi.com/orders/error');
            // }
        } catch (\Exception $e) {
            return response(['Message' => $e->getMessage(), 'Line' => $e->getLine()], 400);
        }
    }

    public function error(Request $request)
    {
         $response = Http::withToken($this->apiToken)->post("https://api-sa.myfatoorah.com/v2/getPaymentStatus", [
            'Key' => $request->paymentId,
            'KeyType' => 'PaymentId',
        ]);
        // $order_id = $response->json('Data')["UserDefinedField"] ? $response->json('Data')["UserDefinedField"] : '';
        // $order = Order::find($order_id);
        // $order->status = 'failed';
        // $order->save();
        return redirect()->away('https://baytalhummus.com/orders/error');
        //return response()->json($response->json('Data'));
    }
}

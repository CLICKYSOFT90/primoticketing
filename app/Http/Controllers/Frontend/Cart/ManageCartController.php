<?php

namespace App\Http\Controllers\Frontend\Cart;

use App\BusinessPersonalLoan;
use App\ContactUs;
use App\HomePage;
use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\TraitLibraries\ResponseWithHttpStatus;

class ManageCartController extends Controller
{
    use ResponseWithHttpStatus;
    protected $mainViewFolder = 'frontend.cart.';

    //
    public function index()
    {
        if(!Website::canPurchaseService()){
            session()->flash('error', 'You are not allowed to do this operation. You have already been subscribed.');
            return redirect(route('front'));
        }

         return view($this->mainViewFolder . 'cart');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($id)
    {
        if(!Website::canPurchaseService()){
            session()->flash('error', 'You are not allowed to do this operation. You have already been subscribed.');
            return redirect(route('front'));
        }

        if(!Website::canBuyMultipleService()){
            session()->flash('error', 'You can add only one service at a time.');
            return redirect(route('front'));
        }

        $product = Service::where('sonar_id',$id)->first();
        if(empty($product)){
            session()->flash('error', 'Invalid service selected');
        }
          
        $cart = session()->get('cart', []);
        $detail = 
        [
            "name" => $product->name,
            "quantity" => 1,
            "amount" => $product->amount,
            "upload_speed_kilobits_per_second" => $product->upload_speed_kilobits_per_second,
            "download_speed_kilobits_per_second" => $product->download_speed_kilobits_per_second,
            "billing_frequency" => $product->billing_frequency,
            "type" => $product->type,
            "application" => $product->application,
            
        ];
        $cart[$id] = $detail;
  
        if(isset($cart[$id])) {
            //$cart[$id]['quantity']++;
        } else {
            
        }
          
        session()->put('cart', $cart);
        return redirect(route('checkout'))->with('success', 'Product added to cart successfully!');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function checkout(Request $request)
    {
        if( count((array) session('cart')) ==0){
            session()->flash('error','Please first add service in cart.');
            return redirect(route('front'));
        }
        $accountDetail = Website::getAccountDetail();
        //dd($accountDetail);
        $address =  $accountDetail['data']->addresses->entities[0];
        return view($this->mainViewFolder . 'checkout',compact('address'));
    }

    public function payment(Request $request)
    {
        if(Website::canPurchaseService()) {
            if (count((array)session('cart')) > 0) {

                $record = Website::addCreditCardToAccount($request);
                $credit_card_id = 0;
                if ($record['success'] == false) {
                    return $this->responseFailure($record['msg'], 422);
                } else {
                    $credit_card_id = $record['sonarId'];
                }
                $amount = 0;

                foreach (session('cart') as $id => $details) {

                    $record = Website::addServiceToAccount($id);
                    if ($record['success'] == false) {
                        return $this->responseFailure($record['msg'], 422);
                    }
                    $amount = $amount + $details['amount'];
                }
                $debits = Website::fetchAccountDebit();

                if ($debits['success'] == false) {
                    return $this->responseFailure($debits['msg'], 422);
                }
                if ($debits['debit_ids'] != "") {
                    $debit = $debits['debit_ids'];
                    if ($amount > 0) {
                        $record = Website::addInvoiceToAccount($debit);
                        if ($record['success'] == false) {
                            return $this->responseFailure($record['msg'], 422);
                        } else {
                            $invoice_id = $record['sonarId'];
                            $data['credit_card_id'] = $credit_card_id;
                            $data['amount'] = $amount * 100;
                            $record = Website::chargeCreditCard($data);
                            if ($record['success'] == false) {
                                return $this->responseFailure($record['msg'], 422);
                            } else {
                                Website::where('id', auth('web')->user()->id)->update(['isServicePurchased' => true]);
                                $contactId = Website::accountContactId();
                                if($contactId){
                                    if(!empty($invoice_id)){
                                        $record = Website::emailInvoiceTrigger($invoice_id,$contactId);
                                        if($record['success']==true){
                                           $invoice_message = "Invoice mailed successfully";
                                        }else{
                                            $invoice_message = "Error in send invoice email. ".$record['msg'];
                                        }
                                    }
                                }
                                session()->flash('success', 'Payment completed successfully. '.$invoice_message);
                                session()->forget('cart');
                                return $this->responseSuccess('Payment completed successfully.', [], 200);
                            }
                        }
                    } else {
                        return $this->responseFailure('Error in payment amount.', 422);
                    }
                } else {
                    return $this->responseFailure('Error in payment generation.', 422);
                }


            } else {
                return $this->responseFailure('Please first add services to your cart.', 422);
            }
        }else{
            return $this->responseFailure('You are not allowed to do this operation. You have already been subscribed.', 422);
        }
        return view($this->mainViewFolder . 'checkout');
    }
}

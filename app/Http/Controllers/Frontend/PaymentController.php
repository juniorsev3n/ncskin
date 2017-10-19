<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Doku;
use App\Models\InfoPaymentMethod;
use App\Models\InfoPengiriman;
use App\Models\LogEmail;
use App\Models\PaymentConfirm;
use App\Models\ProductRegion;
use App\Models\RegionCategory;
use App\Models\RegionCategoryShipping;
use App\Models\SettingEmail;
use App\Models\Shipping;
use App\Models\ShippingAdress;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\WaktuPengiriman;
use Cart;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Image;
use Input;
use Mail;
use Validator;

class PaymentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

		$user    = User::find(session('user_id'));
		$details = Cart::content();
		$incurance = 0;

		$infoManualPayment = InfoPaymentMethod::where('type', 'TF')->orderBy('order')->get();
		$infoOnlinePayment = InfoPaymentMethod::where('type', 'ON')->orderBy('order')->get();


    if(\Sentinel::check()) {
      return view('client.payment.create',compact('details','shipping','user', 'infoManualPayment','infoOnlinePayment','incurance', 'times'));
    } else {
      return Redirect::route('client.carts.index');
    }

      } else {

        return view('client.payment.create',compact('details','shipping','user','times', 'incurance','infoManualPayment','infoOnlinePayment', 'regType'));
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      \Session::put('payment',$request->type_payment);
      return Redirect::route('client.payment.confirm');
    }

    /**
     * Show the form for payment confirmation.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $req)
    {
      try {

        $details = Cart::content();
        $grandTotal = Cart::total();

        $findT = Transaction::where('kode', session('genrate'))->first();
        if ($findT) {
          $findD = TransactionDetail::where('transaction_id',$findT->id)->get();
          if (count($findD) > 0) {
            foreach ($findD as $k => $v) {
              $region = ProductRegion::where('product_id',$v->product_id)->where('city_id',$v->pasar)->where('kemasan',$v->kemasan)->first();
              if ($region) {
                  ProductRegion::where('product_id',$v->product_id)->where('city_id',$v->pasar)->where('kemasan',$v->kemasan)->update(['stock' => $region->stock - $v->qty]);
              }
            }
          }
        }


        $customer = ShippingAdress::join('users','users.id','=','shipping_address.user_id')
        ->join('cities','cities.id','=','shipping_address.city_id')
        ->where('user_id',session('user_id'))
        ->where('kode', session('genrate'))
        ->select('shipping_address.*','users.first_name as user_first_name','users.last_name as user_last_name','cities.name as nm_city','users.email','users.address as user_address','users.phone as user_phone')
        ->first();

        $shipping = Shipping::where('region_category_id',$customer->city_id)->where('type',session('type_komoditi'))->first();

        $incurance = session('incurance');
        $totalIncurance = session('incurancePrice');
        $regType = session('regType');

        $result['user'] = $customer;
        $result['incurance']      = $incurance;
        $result['totalIncurance'] = $totalIncurance;
        $result['grandTotal'] = $grandTotal;


        $result['emails'] = SettingEmail::where('status','TRUE')->get();

        \Session::put('transfer', $req->PAYMENTCHANNEL);
        $info = InfoPengiriman::where('type',session('type_komoditi'))->where('pages_name',2)->first();


        $transId = session('transId');

        $qTrans = Transaction::find($transId);

        // Mail::send('layouts.emails.konfirmation_payment', $result, function ($m) use ($result){
        //   $m->to($result['user']->email, $result['user']->user_first_name);

        //   foreach ($result['emails'] as $value) {
        //     $m->cc($value->email);
        //   }

        //   $m->subject('Paskomnas Payment Confirmation - Invoice #' . session('genrate'));
        // });

        $bankName   = session('bankName');
        $noRek      = session('noRek');
        $noRekOwner = session('noRekOwner');

        $this->postInvoice();

        return view('client.payment.confirm', compact(
            'details',
            'customer',
            'shipping',
            'info',
            'incurance',
            'regType',
            'bankName',
            'noRek',
            'noRekOwner',
            'qTrans'
        ));

      } catch (Exception $e) {
        return redirect()->back();
      }
    }


    public function beforeDone($kode)
    {
      $carts = Cart::content();

      return view('client.payment.before_done',compact('kode'));
    }

    public function storePayment(Request $request)
    {
      $validation = Validator::make($request->all(), ['name' => 'required','norek' => 'required', 'image' => 'required' ]);
      if($validation->fails()) {
        return Redirect::back()->withInput()->withErrors($validation->messages())->with('error', 'Please input the correct data');
      } else {
        DB::beginTransaction();
        try {

          $user = Transaction::where('kode',$request->kode)->first();

          $payment = new PaymentConfirm();
          $payment->name         = $request->name;
          $payment->norek        = $request->norek;
          $payment->bank         = $request->bank;
          $payment->purpose_bank = $request->purpose_bank;
          $payment->user_id      = $user->customer_id;
          $payment->kode         = $request->kode;

          if($request->hasFile('image')){
            $file = Input::file('image');
            $name = $file->getClientOriginalName();

            $path = public_path('images/payment/'. $name);

            $img  = Image::make($file->getRealPath());
            $img->resize(486, 486);
            $img->save($path);

            $nmimage = str_replace(' ', '_', $name);
            $payment->image = $nmimage;
          }
          $payment->save();
          DB::commit();
          return Redirect::route('client.payment.done')->with('success', 'PaymentConfirm successfully added!');
        } catch (Exception $e) {
          DB::rollback();
          return Redirect::route('admin.payment.before_done')->with('error', 'PaymentConfirm can not save to database!');
        }

      }
    }

    public function saveTransaction()
    {

      $genrate = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
      $regId   = session('id_wilayah');

      DB::beginTransaction();
      try{

        if(! session('user_id')) abort(404);

        $user = User::find(session('user_id'));
        \Log::info($user);
        $store = Transaction::where('kode', session('genrate'))->update([
          'type_payment' => 1
          ]);

        $result['datas'] = TransactionDetail::join('transactions','transactions.id','=','transaction_detail.transaction_id')
        ->join('products','products.id','=','transaction_detail.product_id')
        ->join('units','units.id','=','products.unit_id')
        ->where('transactions.kode', session('genrate'))
        ->select('products.name','transaction_detail.*','transactions.kode','units.abbreviation','transactions.paycode')
        ->get();

        $result['emails'] = SettingEmail::where('status','TRUE')->get();
        $result['wilayah'] = RegionCategory::find($regId);

        $result['user']     = User::find($user->id);
        $result['shipping'] = ShippingAdress::where('kode',session('genrate'))->orderBy('id','DESC')->first();
        $result['kode']     = Transaction::where('kode', session('genrate'))->first();
        $result['ps']       = Shipping::where('region_category_id',$result['shipping']->city_id)
        ->where('type',session('type_komoditi'))->first();

        Cart::destroy();

        \Session::forget('user_id');
        \Session::forget('payment');
        \Session::forget('totalPrice');
        \Session::forget('count_cart');
        \Session::forget('pelayanan');
        \Session::forget('shipping');

        \Session::put('kode',session('genrate'));
        \Session::put('grandTotalPrice', Cart::total());

        DB::commit();

        return Redirect::route('client.payment.done');

      } catch(Exception $e){
        DB::rollback();

        return redirect()->back();
      }
    }

    public function postInvoice()
    {
        $genrate = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
        $regId   = session('id_wilayah');

        DB::beginTransaction();

        try{

          if(! session('user_id')) abort(404);

          $user = User::find(session('user_id'));
          \Log::info($user);

          $store = Transaction::where('kode', session('genrate'))->update([
              'type_payment' => 1
          ]);

          $subTotal = 0;

          $qTrans       = Transaction::find(session('transId'));
          $qTransDetail = TransactionDetail::where('transaction_id', $qTrans->id)->get();

          foreach ($qTransDetail as $dt) {
              $subTotal += $dt->qty * $dt->price;
          }

          $grandTotal   = $qTrans->paycode + $qTrans->incurance_price + $qTrans->shipping_price + $subTotal + $qTrans->pelayanan;

          $qTrans->update(['subtotal' => $subTotal, 'grandtotal' => $grandTotal]);


          $result['datas'] = TransactionDetail::join('transactions','transactions.id','=','transaction_detail.transaction_id')
                                              ->join('products','products.id','=','transaction_detail.product_id')
                                              ->join('units','units.id','=','products.unit_id')
                                              ->where('transactions.kode', session('genrate'))
                                              ->select('products.name','transaction_detail.*','transactions.kode','units.abbreviation','transactions.paycode')
                                              ->get();

          $result['emails'] = SettingEmail::where('status','TRUE')->get();
          $result['wilayah'] = RegionCategory::find($regId);

          $result['user']     = User::find($user->id);
          $result['shipping'] = ShippingAdress::where('kode',session('genrate'))->orderBy('id','DESC')->first();
          $result['kode']     = Transaction::where('kode', session('genrate'))->first();
          $result['ps']       = Shipping::where('region_category_id',$result['shipping']->city_id)
          ->where('type',session('type_komoditi'))->first();

          Mail::send('layouts.emails.invoice', $result, function ($m) use ($result){
            $m->to($result['user']->email, $result['user']->first_name);
            foreach ($result['emails'] as $value) {
              $m->cc($value->email);
            }
            $m->subject('Paskomnas Invoice #' . $result['kode']->kode);
          });

          Mail::send('layouts.emails.konfirmation_payment', $result, function ($m) use ($result){
            $m->to($result['user']->email, $result['user']->first_name);

            foreach ($result['emails'] as $value) {
              $m->cc($value->email);
            }

            $m->subject('Paskomnas Payment Confirmation - Invoice #' . session('genrate'));
          });

          DB::commit();

        } catch(Exception $e){
          DB::rollback();
        }
    }

    public function getRecap(Request $request)
    {

      $_data['user']    = User::find(session('user_id'));
      $_data['details'] = Cart::content();

      // $shipping = Shipping::where('region_category_id',session('location'))
      // ->where('type',session('type_komoditi'))
      // ->first();

      $regType   = session('regType');

      $incurance = session('incurance');
      $shipping  = session('shipping');

      $times = WaktuPengiriman::where('status','TRUE')->get();

      $payment =  InfoPaymentMethod::where('code',$request->input('PAYMENTCHANNEL'))->first();
      if($payment && $payment->type == 'TF') {

        $formAction = route('client.payment.confirm');

        $code = $request->input('PAYMENTCHANNEL');
        $q = InfoPaymentMethod::where('code', $code)->first();

        \Session::put('paycode', Transaction::getPayCode());
        \Session::put('PAYMENTCHANNEL', 1);

        \Session::put('bankName', $q->name);
        \Session::put('noRek', $q->norek);
        \Session::put('noRekOwner', $q->owner);

        $pelayanan = 0;

      } else {

        // $formAction = url('https://pay.doku.com/Suite/Receive');
        $formAction = env('PAYMENT_DOKU');
        //$formAction = url('http://staging.doku.com/Suite/Receive');
        \Session::put('paycode', 0);
        \Session::put('PAYMENTCHANNEL', $request->input('PAYMENTCHANNEL'));
        if ($request->input('PAYMENTCHANNEL') == '15') {
          $pelayanan = floor((session('totalPrice') * 3) / 100);
        }else {
          $pelayanan = 0;
        }
      }

      $cc = false;
      if ($request->input('PAYMENTCHANNEL') == '15') {
        $cc = true;
      }

      $_data['formAction'] = $formAction;
      $_data['regType']    = $regType;
      $_data['incurance']  = $incurance;
      $_data['shipping']   = $shipping;
      $_data['pelayanan']   = $pelayanan;
      $_data['creditcard'] = $cc;

      $totalIncurance  = session('incurancePrice');
      $grandTotal      = session('totalPrice');
      $grandTotalFinal = session('totalPrice') + session('paycode');
      $paycodeFinal    = substr($grandTotalFinal, -3);
      $grandTotalFinalBingit = $grandTotal + $pelayanan ;// + $paycodeFinal;

      \Session::put('grandTotalPrice', $grandTotalFinalBingit);
      \Session::put('pelayanan', $pelayanan);

      if($payment && $payment->type == 'TF') {
          session(['paycodeFinal' => session('paycode')]);
      } else {
          session(['paycodeFinal' => 0]);
      }

      // Save Transaction
      Transaction::find(session('transId'))->update([
          'region_category_id' => session('id_wilayah'),
          'subtotal'        => session('price'),
          'paycode'         => session('paycodeFinal'),
          'incurance'       => session('incurance'),
          'incurance_price' => session('incurancePrice'),
          'grandtotal'      => $grandTotalFinalBingit,
          'pelayanan'       => $pelayanan,
      ]);

      return view('client.payment.recap', $_data);
    }

    /**
     * Show the final payment proccess.
     *
     * @return \Illuminate\Http\Response
     */
    public function done()
    {
        Cart::destroy();
        \Session::put('count_cart',Cart::count(false));
        \Session::put('price',0);
        \Session::put('grandTotalPrice', Cart::total());
        $info = InfoPengiriman::where('type',session('type_komoditi'))->where('pages_name',3)->first();

        return view('client.payment.done',compact('info'));
    }

    public function getRedirect(Request $req)
    {
      \Log::info("redirect");
      \Log::info($req->all());

      if($req->STATUSCODE == 0000){

        Cart::destroy();

        \Session::forget('user_id');
        \Session::forget('payment');

        return Redirect::route('client.payment.done');

      } elseif($req->STATUSCODE == 5511){

        \Session::put('payment',$req->PAYMENTCHANNEL);

        $regId   = session('id_wilayah');

        $tr = Transaction::where('kode', $req->TRANSIDMERCHANT);

        Log::info('generate :' . $req->TRANSIDMERCHANT);
        Log::info('ISI: '.  $tr->first());

        $store = $tr->update([
              'type_payment'    => $req->PAYMENTCHANNEL,
              'status_payment'  => 1,
              'status_delivery' => 1,
        ]);

        $carts = Cart::content();
        $tr = $tr->first();

        $userId = $tr->costumer_id;

        $result['user'] = User::find($tr->customer_id);
        $user  = User::find($tr->customer_id);

        if(! $regId)
            $regId = $tr->region_category_id;

        //TransactionDetail::where('transaction_id', $tr->id)->delete();

        $result['datas'] = TransactionDetail::join('transactions','transactions.id','=','transaction_detail.transaction_id')
        ->join('products','products.id','=','transaction_detail.product_id')
        ->join('units','units.id','=','products.unit_id')
        ->where('transactions.id', $tr->id)
        ->select('products.name','transaction_detail.*','transactions.kode','units.abbreviation')
        ->get();

        $result['user']     = User::find($tr->customer_id);
        $result['wilayah']  = RegionCategory::find($regId);

        $result['shipping'] = ShippingAdress::where('user_id',$result['user']->id)->orderBy('id','DESC')->first();
        $result['kode']     = Transaction::find($tr->id);

        //     $result['ps'] = Shipping::where('region_category_id',session('location'))->where('type',session('type_komoditi'))->first();

        $result['emails'] = SettingEmail::where('status','TRUE')->get();
        $result['paymentcode'] = $req->PAYMENTCODE;
        $result['amount'] = $req->AMOUNT;


        Mail::send('layouts.emails.atmbersama', $result, function ($m) use ($result){
          $m->to($result['user']->email, $result['user']->first_name);
          foreach ($result['emails'] as $value) {
            $m->cc($value->email);
          }
          $m->subject('Paskomnas Invoice #' . $result['kode']->kode);
        });

        \Session::put('kode',$tr->kode);
        \Session::put('genrate',$tr->kode);
        \Session::put('user_id',$userId);
        \Session::put('id_transaksi',$tr->id);

        return Redirect::route('client.payment.done');
      } else {
        $tr = Transaction::where('kode', $req->TRANSIDMERCHANT)->first();
        if ($tr) {
          if ($tr->transaction_from == 'mobile') {
            return Redirect::route('api.transaction.dokufailed');
          }else {
            return Redirect::route('client.payment.create');
          }
        }else {
          return Redirect::route('client.payment.create');
        }
      }
    }

    public function getNotify(Request $req)
    {
      \Log::info('notify');
      \Log::info($req->all());
      if($req->RESPONSECODE == 0000){
        \Log::info($req->all());
        $doku = new Doku();
        $doku->transidmerchant = $req->TRANSIDMERCHANT;
        $doku->totalamount = $req->AMOUNT;
        $doku->words = $req->WORDS;
        $doku->statustype = $req->STATUSTYPE;
        $doku->response_code = $req->RESPONSECODE;
        $doku->approvalcode = $req->APPROVALCODE;
        $doku->payment_channel = $req->PAYMENTCHANNEL;
        $doku->paymentcode = $req->MCN;
        $doku->session_id = $req->SESSIONID;
        $doku->bank_issuer = $req->BANK;
        $doku->payment_date_time = $req->PAYMENTDATETIME;
        $doku->verifyid = $req->VERIFYID;
        $doku->verifyscore = $req->VERIFYSCORE;
        $doku->verifystatus = $req->VERIFYSTATUS;
        $doku->trxstatus   = 'Success';
        $doku->save();

        $findT = Transaction::where('kode', $req->TRANSIDMERCHANT)->first();
        if ($findT) {
          $findD = TransactionDetail::where('transaction_id',$findT->id)->get();
          if (count($findD) > 0) {
            foreach ($findD as $k => $v) {
              $region = ProductRegion::where('product_id',$v->product_id)->where('city_id',$v->pasar)->where('kemasan',$v->kemasan)->first();
              if ($region) {
                  ProductRegion::where('product_id',$v->product_id)->where('city_id',$v->pasar)->where('kemasan',$v->kemasan)->update(['stock' => $region->stock - $v->qty]);
              }
            }
          }
        }

        if($req->PAYMENTCHANNEL == "02" || $req->PAYMENTCHANNEL == "15" || $req->PAYMENTCHANNEL == "04"){
          Transaction::where('kode',$req->TRANSIDMERCHANT)->update([
            'status_payment' => 2,
            'type_payment' => $req->PAYMENTCHANNEL,
            ]);

          $data = Transaction::join('users','users.id','=','transactions.customer_id')
          ->where('kode',$req->TRANSIDMERCHANT)
          ->select('transactions.*','users.first_name','users.last_name','users.email')
          ->first();

          $result['datas'] = TransactionDetail::join('transactions','transactions.id','=','transaction_detail.transaction_id')
                                              ->join('products','products.id','=','transaction_detail.product_id')
                                              ->join('units','units.id','=','products.unit_id')
                                              ->where('transactions.kode', $req->TRANSIDMERCHANT)
                                              ->select('products.name','transaction_detail.*','transactions.kode','units.abbreviation')
                                              ->get();

          $result['user'] = User::find($data->customer_id);


          $qTransaction = Transaction::find($data->id);

          $result['shipping'] = ShippingAdress::where('user_id',$data->customer_id)->orderBy('id','DESC')->first();
          $result['kode']     = $qTransaction;
          $result['wilayah']  = RegionCategory::find($data->location);
          $result['ps']       = Shipping::where('region_category_id',$data->location)
                                          ->where('type',$data->type_komoditi)
                                          ->first();

          $result['emails']   = SettingEmail::where('status','TRUE')->get();
          $result['type']     = 'doku';
          \Log::info( $result['kode']  );
          \Log::info( $result  );
          Mail::send('layouts.emails.invoice', $result, function ($m) use ($result){
              $m->to($result['user']->email, $result['user']->first_name);
              foreach ($result['emails'] as $value) {
                $m->cc($value->email);
              }
              $m->subject('Paskomnas Invoice #' . $result['kode']->kode);
          });

          $log_mail = new LogEmail;
          $log_mail->code = $req->TRANSIDMERCHANT;

          if (Mail::failures()) {
            $log_mail->status = 1;
          } else {
            $log_mail->status = 0;
          }

          $log_mail->save();

          Mail::send('layouts.emails.success_payment', $result, function ($m) use ($result){
            $m->to($result['user']->email, $result['user']->first_name);
            $m->subject('Payment Complete');
          });
        }

        if($req->PAYMENTCHANNEL == "05")
        {
          Transaction::where('kode',$req->TRANSIDMERCHANT)->update([
              'status_payment' => 2,
              'type_payment'   => '05',
          ]);

          $result['datas'] = TransactionDetail::join('transactions','transactions.id','=','transaction_detail.transaction_id')
                                              ->join('products','products.id','=','transaction_detail.product_id')
                                              ->join('units','units.id','=','products.unit_id')
                                              ->where('transactions.kode', $req->TRANSIDMERCHANT)
                                              ->select('products.name','transaction_detail.*','transactions.kode','units.abbreviation')
                                              ->get();

          $result['user'] = Transaction::join('users','users.id','=','transactions.customer_id')
          ->where('kode',$req->TRANSIDMERCHANT)
          ->select('users.*')
          ->first();
          $result['shipping'] = ShippingAdress::where('user_id',$result['user']->id)->orderBy('id','DESC')->first();
          $result['emails']   = SettingEmail::where('status','TRUE')->get();
          $result['paymentcode'] = $req->PAYMENTCODE;
          $result['amount'] = $req->AMOUNT;
          $result['kode'] = Transaction::where('kode',$req->TRANSIDMERCHANT)->first();

          Mail::send('layouts.emails.atmbersama', $result, function ($m) use ($result){
            $m->to($result['user']->email, $result['user']->first_name);
            foreach ($result['emails'] as $value) {
            $m->cc($value->email);
          }
            $m->subject('Paskomnas Invoice #' . $result['kode']->kode);
          });

          Mail::send('layouts.emails.success_payment', $result, function ($m) use ($result){
            $m->to($result['user']->email, $result['user']->first_name);
            $m->subject('Payment Complete');
          });
          $log_mail = new LogEmail;
          $log_mail->code = $req->TRANSIDMERCHANT;
          if (Mail::failures()) {
            $log_mail->status = 1;
          } else {
            $log_mail->status = 0;
          }
          $log_mail->save();
        }
        echo 'CONTINUE';
      }else{
        echo 'error';
      }
    }

    public function dialog(Request $req)
    {
        $result = [];

        if($req->payment == 1){
          $select = '<p>Anda akan melakukan permbayaran dengan Metode Transfer</p>';
        }else{
          $select = '<select class="form-control" name="PAYMENTCHANNEL">
          <option value="">-Pilih Metode Pembayaran-</option>
          <option value="15">Credit Card Visa</option>
          <option value="02">Mandiri ClickPay</option>
          <option value="04">Doku Walet</option>
          <option value="05">ATM Permata VA</option>
        </select>';
       }

      $result['select'] = $select;
      $result['kode']   = $req->payment;

      return response()->json($result);
    }

    public function getInvoice($kode)
    {
      $data = Transaction::join('users','users.id','=','transactions.customer_id')
      ->where('kode',$kode)
      ->select('transactions.*','users.first_name','users.last_name','users.email')
      ->first();
      if ($data) {
        $result['datas'] = TransactionDetail::join('transactions','transactions.id','=','transaction_detail.transaction_id')
                                            ->join('products','products.id','=','transaction_detail.product_id')
                                            ->join('units','units.id','=','products.unit_id')
                                            ->where('transactions.kode', $kode)
                                            ->select('products.name','transaction_detail.*','transactions.kode','units.abbreviation')
                                            ->get();

        $result['user'] = User::find($data->customer_id);


        $qTransaction = Transaction::find($data->id);

        $result['shipping'] = ShippingAdress::where('user_id',$data->customer_id)->where('kode',$kode) ->orderBy('id','DESC')->first();
        $result['kode']     = $qTransaction;
        $result['wilayah']  = RegionCategory::find($data->location);
        $result['ps']       = Shipping::where('region_category_id',$data->location)
                                        ->where('type',$data->type_komoditi)
                                        ->first();

        $result['emails']   = SettingEmail::where('status','TRUE')->get();
        $pdf = \PDF::loadView('client.invoice', $result);

        return $pdf->stream();
      }else {
        echo "transaction not found";
      }
    }

}


<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;
use App\Service;
use App\Sale;
use App\Supplier;
use App\Invoice;
use App\User;
use App\SalesCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $invoices = Invoice::where('process', 'pending')->get();
        //dd($invoices);
        return view('invoice.index', compact('invoices'));
    }
    public function process($status)
    {
        $invoices = array();

        if ($status == "1") {
            $invoices = Invoice::where('process', 'pending')->get();
        } else if ($status == "2") {
            $invoices = Invoice::where('process', 'inprogress')->get();
          
        }else if($status="3"){
            $invoices = Invoice::where('process', 'processed')->get();
        }
        return view('invoice.index', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $work_agents = User::all();
        $products = Product::all();
        $services = Service::all();
        return view('invoice.create', compact('customers','work_agents','products','services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([

            'customer_id' => 'required|numeric',
            'created_on' => 'required',
            'user_id' => 'required|numeric',
            'product_id' => 'required',
            'product_id.*' => 'required|numeric',
            'qty' => 'required',
            'qty.*' => 'required|numeric|gt:0',
            'price' => 'required',
            'price.*' => 'required|numeric|gt:0',
            'dis' => 'required',
            'dis.*' => 'required|numeric',
            'amount' => 'required',
            'amount.*' => 'required|numeric|gt:0',
        ]);
        // die("jj");
        $invoice = new Invoice();
        $invoice->customer_id = $request->customer_id;
        $invoice->created_on = $request->created_on;
        // dd($invoice->created_on);
        $invoice->workagent_id = $request->user_id;
        $invoice->total = 1000;
        $invoice->process = 'pending';
        $invoice->save();
        $amount = 0;
        $commission = 0;
        foreach ($request->product_id as $key => $product_id) {
            $sale = new Sale();
            $sale->qty = $request->qty[$key];
            $sale->price = $request->price[$key];
            $sale->dis = $request->dis[$key];
            $sale->amount = $request->amount[$key];
            $sale->product_id = $request->product_id[$key];
            $sale->invoice_id = $invoice->id;
            $sale->created_on = $request->created_on;
            $sale->save();
            $product = Product::find($product_id);
            $amount += $request->amount[$key];
            $commission += $product->commission_percentage*$amount/100; 
        }

        // dd($commission);
        $sc = new SalesCommission;        
        $sc->commission = $commission;  
        // $sc->workagent_id = auth()->user()->id;  
        $sc->workagent_id =$request->user_id;  
        $sc->invoice_id = $invoice->id;
        $sc->created_on = $request->created_on;
        $sc->save();

        $invoice->id =  $invoice->id;
        $invoice->total = $amount;
        if ($invoice->update()) {
            return redirect('invoice/' . $invoice->id)->with('message', 'invoice created Successfully');
        } else {
            return back();
        }

        //return redirect('invoice/'.$invoice->id)->with('message','invoice created Successfully');




    }

    public function findPrice(Request $request)
    {
        $data = DB::table('products')->select('sales_price')->where('id', $request->id)->first();
        return response()->json($data);
    }
    public function invoices(Request $request)
    {
        $data = Invoice::where(DB::raw('total-paid'), '>', '0')->where('customer_id', "=", $request->id)->get('id');
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $sales = Sale::where('invoice_id', $id)->get();
        return view('invoice.show', compact('invoice', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers = Customer::all();
        $users = User::all();
        $products = Product::orderBy('id', 'DESC')->get();
        $invoice = Invoice::findOrFail($id);
        // dd($invoice->created_on);
        $sales = Sale::where('invoice_id', $id)->get();
        return view('invoice.edit', compact('customers', 'products', 'invoice', 'sales','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->created_on);
        $request->validate([

            'customer_id' => 'required|numeric',
            'product_id' => 'required',
            'product_id.*' => 'required|numeric',
            'qty' => 'required',
            'qty.*' => 'required|numeric|gt:0',
            'price' => 'required',
            'price.*' => 'required|numeric|gt:0',
            'dis' => 'required',
            'dis.*' => 'required|numeric',
            'amount' => 'required',
            'amount.*' => 'required|numeric|gt:0',
        ]);
        $invoice = Invoice::findOrFail($id);
        $invoice->customer_id = $request->customer_id;
        $invoice->workagent_id = $request->user_id;        
        $amount = 0;
        $commission = 0;

        foreach ($request->product_id as $key => $product_id) {
        $invoice->total = $request->amount[$key];
        $amount = $request->amount[$key];        
        $product = Product::find($product_id);
        $commission += $product->commission_percentage*$amount/100; 
        }
        $invoice->save();

        Sale::where('invoice_id', $id)->delete();

        foreach ($request->product_id as $key => $product_id) {
            $sale = new Sale();
            $sale->qty = $request->qty[$key];
            $sale->price = $request->price[$key];
            $sale->dis = $request->dis[$key];
            $sale->amount = $request->amount[$key];
            $sale->product_id = $request->product_id[$key];
            $sale->invoice_id = $invoice->id;
            $sale->created_on = $invoice->created_on;
            $sale->save();
        }

        SalesCommission::where('invoice_id', $id)->delete();

        foreach ($request->product_id as $key => $product_id) {
        $sc = new SalesCommission();
        $sc->commission = $commission;   
        $sc->invoice_id =$id;  
        $sc->workagent_id =$request->user_id;  
        $sc->created_on = $invoice->created_on;
        $sc->save();
        }

        // Flash a success message to the session
        session()->flash('alert-success', 'Record updated successfully!');

        return redirect()->action('ReportsController@daily_sales');
        // return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        
        // Flash a success message to the session
        session()->flash('alert-success', 'Record deleted successfully!!!');

        return redirect()->action('ReportsController@daily_sales');
    }
    public function approve($id)
    {
        $invoice = Invoice::findOrFail($id);
        if($invoice->process=="pending"){
              Sms::send("0714241029",
                "Dear Customer, Your application status for invoice ".$invoice->id."  changed to processing as it is being worked on.
                We will notify you once the process is done.
               ");
            $invoice->process="inprogress";
        }
        else if( $invoice->process=="inprogress"){
            Sms::send("0714241029",
            "Dear customer, Your invoice ".$invoice->id." has been proessed successfully Kindly visit our office for more. Thank you ");
            $invoice->process = "processed";
        }

      //  $invoice->process = "processed";
       // dd($invoice);
        if ($invoice->save()) {
            return redirect()->back()->with("message", "Approved Successfully");
        } else {
            return redirect()->back()->with("error", "Failed to Approve!");
        }
    }
}

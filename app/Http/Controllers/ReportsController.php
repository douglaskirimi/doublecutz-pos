<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Category;
use App\Customer;
use App\Product;
use App\Invoice;
use App\ProductSupplier;
use App\Supplier;
use App\Tax;
use App\Unit;
use App\Service;
use App\User;
use App\Sale;
use App\SalesCommission;
use Auth;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function daily_sales()
    {
        // $daily_sales = Sale::all();
        $daily_sales = Sale::whereRaw('date(created_at) = curdate()')->whereRaw('date(created_on) = curdate()')->with('product')->get();
        // die(json_encode($daily_sales));
       return view('reports.daily_sales',compact('daily_sales'));

    }

       public function filter_sales(Request $request)
    {
        $fromDate = $request->startDate;
        $toDate = $request->endDate;
        $data = compact('fromDate','toDate');
        // dd($data);

         $filtered_sales = Sale::whereDate('created_on', '>=', $fromDate)
            ->whereDate('created_on', '<=', $toDate)
            ->get();

       return view('reports.filtered_sales',compact('filtered_sales','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function daily_commission()
    {
        $employees = User::all();
        // dd($employees);
        // $id = auth()->user()->id;
         $daily_commission = SalesCommission::whereRaw('date(created_at) = curdate()')->whereRaw('date(created_on) = curdate()')->with('employee','invoice.sale.product')->get();
         // dd($daily_commission);

         // $daily_individual_commission = SalesCommission::where('id',$id)->with('employee','invoice.sale.product')->get();

       return view('reports.daily_commissions',compact('daily_commission','employees'));
    }

   public function filter_commission(Request $request)
    {
        $employees = User::all();
        $selectedDate = $request->date;
        $workagent_id = $request->workagent_id;
        $data = compact('selectedDate','workagent_id');
        // dd($data);

         // $employee_commission = SalesCommission::where('workagent_id', '=', $workagent_id)->with('employee','invoice.sale.product')->get();

           $employee_commission = SalesCommission::whereDate('created_on', $selectedDate)->where('workagent_id',$workagent_id)->with('employee','invoice.sale.product')->get();

         

            // dd($employee_commission);

       return view('reports.filter_individual_commission',compact('employee_commission','data','employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $reports_data = Sale::findorFail($id);
        $invoice = Invoice::findorFail($id);
        $sales = Sale::where('invoice_id', $id)->get();

        $product_id =  $sales->pluck('product_id');
        $products=Product::where('id', $product_id)->get();
        // dd($products);
        // dd($reports_data);

        $customers = Customer::all();
        $work_agents = User::all();
        $products = Product::all();
        $services = Service::all();
        return view('reports.edit', compact('customers','work_agents','products','services','invoice','sales'));
       // return view('reports.edit', compact('reports_data'));
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
        dd($request->created_on);
        // $request->validate([

        //     'customer_id' => 'required|numeric',
        //     'created_on' => 'required',
        //     'product_id' => 'required',
        //     'product_id.*' => 'required|numeric',
        //     'qty' => 'required',
        //     'qty.*' => 'required|numeric|gt:0',
        //     'price' => 'required',
        //     'price.*' => 'required|numeric|gt:0',
        //     'dis' => 'required',
        //     'dis.*' => 'required|numeric',
        //     'amount' => 'required',
        //     'amount.*' => 'required|numeric|gt:0',
        // ]);
        $invoice = Invoice::findOrFail($id);
        $invoice->customer_id = $request->customer_id;
        // $fjjf= $invoice->customer_id;
        // dd($fjjf);
        // $invoice->workagent_id = $request->served_by;
        $invoice->total = 1000;
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
            $sale->created_on = $request->created_on;
            $sale->save();
            dd('success');
        }

        // return redirect('invoice/' . $invoice->id)->with('message', 'invoice created Successfully');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->delete();


        $invoice = Invoice::find($id);
        $invoice->delete();


        $salesCommission = SalesCommission::find($id);
        $salesCommission->delete();
        return redirect()->back();
    }
}

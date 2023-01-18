<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Category;
use App\Product;
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
        $daily_sales = Sale::whereRaw('date(created_at) = curdate()')->with('product')->get();
        // die(json_encode($daily_sales));
       return view('reports.daily_sales',compact('daily_sales'));

    }

       public function filter_sales(Request $request)
    {
        $fromDate = $request->startDate;
        $toDate = $request->endDate;
        $data = compact('fromDate','toDate');
        // dd($data);

         $filtered_sales = Sale::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
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
        $id = auth()->user()->id;
         $daily_commission = SalesCommission::whereRaw('date(created_at) = curdate()')->with('employee','invoice.sale.product')->get();

         $daily_individual_commission = SalesCommission::where('id',$id)->with('employee','invoice.sale.product')->get();
         // dd($daily_individual_commission);

         // dd($daily_individual_commission);
        // die(json_encode($daily_commission));
       return view('reports.daily_commission',compact('daily_commission'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

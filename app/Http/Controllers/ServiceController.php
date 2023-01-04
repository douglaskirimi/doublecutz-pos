<?php
namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductSupplier;
use App\Supplier;
use App\Tax;
use App\Unit;
use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        // $products = Product::all();
        $services = Service::all();
        // dd($services);
        // $additional = ProductSupplier::all();
      
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers =Supplier::all();
        $categories = Category::all();
        $taxes = Tax::all();
   
        // return view('services.create', compact('categories'));
   
        return view('services.create', compact('categories','taxes','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         $request->validate([
            'service_name' => 'required|min:3|unique:services|regex:/^[a-zA-Z ]+$/',
            'category_id' => 'required',
            'service_fee' => 'required',
            
        ]);


        $service = new Service();
        $service->name = $request->name;
        $product->category_id = $request->category_id;
        $product->service_fees = $request->service_fees;
        // $product->serial_number = $request->serial_number;
        // $product->model = $request->model;
        // $product->tax_id = $request->tax_id;



        $service->save();

        // foreach($request->supplier_id as $key => $supplier_id){
        //     $supplier = new ProductSupplier();
        //     $supplier->product_id = $product->id;
        //     $supplier->supplier_id = $request->supplier_id[$key];
        //     $supplier->price = $request->supplier_price[$key];
        //     $supplier->save();
        // }
        return redirect()->back()->with('message', 'Service Created Successfully');
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
        // $additional =ProductSupplier::findOrFail($id);
        $services =Service::findOrFail($id);
        // $suppliers =Supplier::all();
        $categories = Category::all();
        // $taxes = Tax::all();
    
        return view('service.edit', compact('services','categories'));
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
        $request->validate([
            'name' => 'required|min:3|unique:services|regex:/^[a-zA-Z ]+$/',
            // 'serial_number' => 'required',
            // 'model' => 'required|min:1',
            'category_id' => 'required',
            'service_fee' => 'required',
            // 'tax_id' => 'required',

        ]);


        $service = new Service();
        $service->service_name = $request->name;
        // $product->serial_number = $request->serial_number;
        // $product->model = $request->model;
        $service->category_id = $request->category_id;
        $service->service_fee = $request->service_fee;
        // $service->tax_id = $request->tax_id;


        $service->save();

        // foreach($request->supplier_id as $key => $supplier_id){
        //     $supplier = new ProductSupplier();
        //     $supplier->product_id = $product->id;
        //     $supplier->supplier_id = $request->supplier_id[$key];
        //     $supplier->price = $request->supplier_price[$key];
        //     $supplier->save();
        // }
        return redirect()->back()->with('message', 'Service Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        $service->delete();
        return redirect()->back();

    }
}
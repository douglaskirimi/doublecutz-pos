<?php
namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductSupplier;
use App\Supplier;
use App\Tax;
use App\Unit;
use App\Service;
use App\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $products = Product::all();
        $services = Service::all();
        // dd($services);
        // $additional = ProductSupplier::all();
      
        return view('services.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users =User::where('role_id','=',2)->get();
        // dd($users);
        $categories = Category::all();
        $taxes = Tax::all();
   
        // return view('services.create', compact('categories'));
   
        return view('services.create', compact('categories','taxes','users'));
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
            'service_name' => 'required|min:3|regex:/^[a-zA-Z ]+$/',
            'category_id' => 'required',
            'service_fee' => 'required',
            'commission_percentage' => 'required',
            
        ]);


        // $service = new Service();
        // $service->service_name = $request->service_name;
        // $service->category_name = $request->category_name;
        // $service->service_fee = $request->service_fee;

         $product = new Product();
        $product->name = $request->service_name;
        $product->category_id = $request->category_id;
        $product->sales_price = $request->service_fee;
        $product->commission_percentage = $request->commission_percentage;
        // $product->model = $request->model;
        $product->tax_id = 0;



        $product->save();

        // foreach($request->supplier_id as $key => $supplier_id){
        //     $supplier = new ProductSupplier();
        //     $supplier->product_id = $product->id;
        //     $supplier->supplier_id = $request->supplier_id[$key];
        //     $supplier->price = $request->supplier_price[$key];
        //     $supplier->save();
        // }
        return redirect()->back()->with('message', 'Service Created Successfully');

        // $services = Product::all();
        // return view('services.index', compact('services'));
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
     * @return \Illuminssate\Http\Response
     */
    public function edit($id)
    {
        // $additional =ProductSupplier::finsdOrFail($id);
        $ca =Product::findOrFail($id)->with('category')->get();
        $service =Product::findOrFail($id);
        // die($service);
        // $suppliers =Supplier::all();
        $categories = Category::all();
        $taxes = Tax::all();
    
        return view('services.edit', compact('service','categories','taxes','ca'));
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
            'service_name' => 'required|min:3|regex:/^[a-zA-Z ]+$/',
            'category_id' => 'required',
            'sales_price' => 'required',
            'category_id' => 'required',
            'commission_percentage' => 'required',

        ]);


        $service = Product::findOrFail($id);
        $service->name = $request->service_name;
        $service->category_id = $request->category_id;
        $service->sales_price = $request->sales_price;
        $service->commission_percentage = $request->commission_percentage;
        $service->tax_id = 0;
        $service->save();

        return redirect()->back()->with('message', 'Service Updated Successfully');
        // return view('services.index', compact('services'))->with('message', 'Service Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Product::find($id);
        $service->delete();
        return redirect()->back();

    }
}

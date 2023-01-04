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

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        // $products = Product::all();
        $products = Service::all();
        $additional = ProductSupplier::all();
      
        return view('product.index', compact('products','additional'));
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
   
        return view('product.create', compact('categories','taxes','suppliers'));
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
            'name' => 'required|min:3|unique:products|regex:/^[a-zA-Z ]+$/',
            'category_id' => 'required',
            'sales_price' => 'required',
            
        ]);


        $product = new Product();
        $product->name = $request->name;
        // $product->serial_number = $request->serial_number;
        // $product->model = $request->model;
        $product->category_id = $request->category_id;
        $product->sales_price = $request->sales_price;
        $product->tax_id = $request->tax_id;



        $product->save();

        foreach($request->supplier_id as $key => $supplier_id){
            $supplier = new ProductSupplier();
            $supplier->product_id = $product->id;
            $supplier->supplier_id = $request->supplier_id[$key];
            $supplier->price = $request->supplier_price[$key];
            $supplier->save();
        }
        return redirect()->back()->with('message', 'Product Created Successfully');
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
        $additional =ProductSupplier::findOrFail($id);
        $product =Product::findOrFail($id);
        $suppliers =Supplier::all();
        $categories = Category::all();
        $taxes = Tax::all();
    
        return view('product.edit', compact('additional','suppliers','categories','taxes','product'));
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
            'name' => 'required|min:3|unique:products|regex:/^[a-zA-Z ]+$/',
            'serial_number' => 'required',
            'model' => 'required|min:1',
            'category_id' => 'required',
            'sales_price' => 'required',
            'tax_id' => 'required',

        ]);


        $product = new Product();
        $product->name = $request->name;
        // $product->serial_number = $request->serial_number;
        // $product->model = $request->model;
        $product->category_id = $request->category_id;
        $product->sales_price = $request->sales_price;
        $product->tax_id = $request->tax_id;





        $product->save();

        foreach($request->supplier_id as $key => $supplier_id){
            $supplier = new ProductSupplier();
            $supplier->product_id = $product->id;
            $supplier->supplier_id = $request->supplier_id[$key];
            $supplier->price = $request->supplier_price[$key];
            $supplier->save();
        }
        return redirect()->back()->with('message', 'Product Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back();

    }
}

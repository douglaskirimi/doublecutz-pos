<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;
use App\Sale;
use App\Supplier;
use App\Invoice;
use App\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
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
    public function paymentPie(){
        $payment=\App\Payment::where('status','active')->where('reversed','no')->whereDate('created_at',\Carbon\Carbon::today())->sum('amount');
        $invoices=\App\Invoice::whereDate('created_at',\Carbon\Carbon::today())->sum('total');
        return response()->json(compact('payment','invoices'));
    }
    public function paymentGraph(){
        $labels = array();
        $payments = array();
        $invoices = array();
        for ($i = 12; $i >= 1; $i--) {
            
            $month = \Carbon\Carbon::today()->subMonth($i);
            $year = \Carbon\Carbon::today()->subMonth($i)->format('Y');
            array_push($labels,$month->shortMonthName);
            $payment=Payment::select("sum")->where('status','active')->where('reversed','no')->whereMonth('created_at',$month)->sum("amount");
           // return response()->json($payment);
            array_push ($payments,$payment);
            array_push($invoices,Invoice::where('status','active')->whereMonth('created_at',$month)->sum("total"));
         
        }
        // s
        $payment=\App\Payment::where('status','active')->where('reversed','no')->whereDate('created_at',\Carbon\Carbon::today())->sum('amount');
        $inv=\App\Invoice::whereDate('created_at',\Carbon\Carbon::today())->sum('total');
        return response()->json(compact('labels','payments','invoices','payment','inv'));
    }

    public function index()
    {
        $invoices = Invoice::all();
        return view('receipt.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('receipt.create', compact('customers','products'));
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
            'invoice_id' => 'required|numeric',
            'amount' => 'required:numeric:gt:0',
         
        ]);

        $payment=new Payment();
        $payment->customer_id=$request->customer_id;
        $payment->invoice_id=$request->invoice_id;
        $payment->amount=$request->amount;
        if($payment->save()){
            $invoice= Invoice::find($request->invoice_id);
            $invoice->paid= $invoice->paid+$request->amount;
           if($invoice->save()){

            return redirect('receipt/'.$request->invoice_id)->with('message','Receipt created Successfully');
           }
            
          
        }
        else{
            return back()->with('error','Receipt failed Retry');
        }

        




    }

    public function findInvoice(Request $request){
        // $data = DB::table('products')->select('sales_price')->where('id', $request->id)->first();
        $total=Sale::where('invoice_id',$request->id)->sum('amount');
        $paid=Payment::where("invoice_id",$request->id)->sum("amount");
        $invoice = Invoice::with('sale.product')
        ->where('id',$request->id)
        ->where('customer_id',$request->customer)
        ->get()
        ->first();
        $balance=$total-$paid;

      //  die(json_encode($invoice));
        return response()->json(compact('invoice','total','paid','balance'));
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
       
        $payment=Payment::where("invoice_id",$id)->orderByDesc('updated_at')->firstOrFail();
        $words=ucwords($this->convertNumber(sprintf("%.2f", $payment->amount)));
        return view('receipt.show', compact('invoice','sales','payment','words'));

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
        $products = Product::orderBy('id', 'DESC')->get();
        $invoice = Invoice::findOrFail($id);
        $sales = Sale::where('invoice_id', $id)->get();
        return view('receipt.edit', compact('customers','products','invoice','sales'));
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

        'customer_id' => 'required',
        'product_id' => 'required',
        'qty' => 'required',
        'price' => 'required',
        'dis' => 'required',
        'amount' => 'required',
    ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->customer_id = $request->customer_id;
        $invoice->total = 1000;
        $invoice->save();

        Sale::where('invoice_id', $id)->delete();

        foreach ( $request->product_id as $key => $product_id){
            $sale = new Sale();
            $sale->qty = $request->qty[$key];
            $sale->price = $request->price[$key];
            $sale->dis = $request->dis[$key];
            $sale->amount = $request->amount[$key];
            $sale->product_id = $request->product_id[$key];
            $sale->invoice_id = $invoice->id;
            $sale->save();


        }

         return redirect('invoice/'.$invoice->id)->with('message','invoice created Successfully');


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
        return redirect()->back();

    }
    private function convertNumber ($number){
        
            list($integer, $fraction) = explode(".", (string) $number);
        
            $output = "";
        
            if ($integer[0] == "-")
            {
                $output = "negative ";
                $integer    = ltrim($integer, "-");
            }
            else if ($integer[0] == "+")
            {
                $output = "positive ";
                $integer    = ltrim($integer, "+");
            }
        
            if ($integer[0] == "0")
            {
                $output .= "zero";
            }
            else
            {
                $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
                $group   = rtrim(chunk_split($integer, 3, " "), " ");
                $groups  = explode(" ", $group);
        
                $groups2 = array();
                foreach ($groups as $g)
                {
                    $groups2[] = $this->convertThreeDigit($g[0], $g[1], $g[2]);
                }
        //ss
                for ($z = 0; $z < count($groups2); $z++)
                {
                    if ($groups2[$z] != "")
                    {
                        $output .= $groups2[$z] . $this->convertGroup(11 - $z) . (
                                $z < 11
                                && !array_search('', array_slice($groups2, $z + 1, -1))
                                && $groups2[11] != ''
                                && $groups[11][0] == '0'
                                    ? " and "
                                    : ", "
                            );
                    }
                }
        
                $output = rtrim($output, ", ");
            }
        
            if ($fraction > 0)
            {
                $output .= "Shillings And";
                for ($i = 0; $i < strlen($fraction); $i++)
                {
                    $output .= " " . $this->convertDigit($fraction[$i])." Cents Only";
                }
            }else{
                $output .=" Shillings Only";
            }
        
            return $output ;
        }
        
       private function convertGroup($index)
        {
            switch ($index)
            {
                case 11:
                    return " decillion";
                case 10:
                    return " nonillion";
                case 9:
                    return " octillion";
                case 8:
                    return " septillion";
                case 7:
                    return " sextillion";
                case 6:
                    return " quintrillion";
                case 5:
                    return " quadrillion";
                case 4:
                    return " trillion";
                case 3:
                    return " billion";
                case 2:
                    return " million";
                case 1:
                    return " thousand";
                case 0:
                    return "";
            }
        }
        
       private function convertThreeDigit($digit1, $digit2, $digit3)
        {
            $buffer = "";
        
            if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
            {
                return "";
            }
        
            if ($digit1 != "0")
            {
                $buffer .= $this->convertDigit($digit1) . " hundred";
                if ($digit2 != "0" || $digit3 != "0")
                {
                    $buffer .= " and ";
                }
            }
        
            if ($digit2 != "0")
            {
                $buffer .= $this->convertTwoDigit($digit2, $digit3);
            }
            else if ($digit3 != "0")
            {
                $buffer .= $this->convertDigit($digit3);
            }
        
            return $buffer;
        }
        
     private   function convertTwoDigit($digit1, $digit2)
        {
            if ($digit2 == "0")
            {
                switch ($digit1)
                {
                    case "1":
                        return "ten";
                    case "2":
                        return "twenty";
                    case "3":
                        return "thirty";
                    case "4":
                        return "forty";
                    case "5":
                        return "fifty";
                    case "6":
                        return "sixty";
                    case "7":
                        return "seventy";
                    case "8":
                        return "eighty";
                    case "9":
                        return "ninety";
                }
            } else if ($digit1 == "1")
            {
                switch ($digit2)
                {
                    case "1":
                        return "eleven";
                    case "2":
                        return "twelve";
                    case "3":
                        return "thirteen";
                    case "4":
                        return "fourteen";
                    case "5":
                        return "fifteen";
                    case "6":
                        return "sixteen";
                    case "7":
                        return "seventeen";
                    case "8":
                        return "eighteen";
                    case "9":
                        return "nineteen";
                }
            } else
            {
                $temp = $this->convertDigit($digit2);
                switch ($digit1)
                {
                    case "2":
                        return "twenty-$temp";
                    case "3":
                        return "thirty-$temp";
                    case "4":
                        return "forty-$temp";
                    case "5":
                        return "fifty-$temp";
                    case "6":
                        return "sixty-$temp";
                    case "7":
                        return "seventy-$temp";
                    case "8":
                        return "eighty-$temp";
                    case "9":
                        return "ninety-$temp";
                }
            }
        }
        
      private  function convertDigit($digit)
        {
            switch ($digit)
            {
                case "0":
                    return "zero";
                case "1":
                    return "one";
                case "2":
                    return "two";
                case "3":
                    return "three";
                case "4":
                    return "four";
                case "5":
                    return "five";
                case "6":
                    return "six";
                case "7":
                    return "seven";
                case "8":
                    return "eight";
                case "9":
                    return "nine";
            }
}
}

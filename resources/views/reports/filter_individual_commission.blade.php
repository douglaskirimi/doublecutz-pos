@extends('layouts.master')

@section('title', 'Invoice | ')
@section('content')
    @include('partials.header')
    @include('partials.sidebar')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-file-home"></i> Double Cutz Spa and Kinyozi </h1>
                <!-- <p>A Printable Invoice Format</p> -->
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class=""></i></li>
                <li class="breadcrumb-item"><i href="#">Double Cutz Spa & Kinyozi Receipt</i></li>
            </ul>
        </div>

                  <div class="container my-4">
       <form  method="POST" action="{{route('filter_commission')}}">
        @csrf
    <p><strong>See Commission Earned By Each Employee</strong></p>
  
  <!--Grid row-->
  <div class="row">

    <!--Grid column-->
    <div class="col-md-6 mb-4">

      <div class="md-form">
                                {{-- <label class="control-label">Customer Name</label> --}}
                                <select name="employee_id" class="form-control" placeholder="{{old('employee_id')}}" required="required">
                                    <option>Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option name="employee_id" value="{{$employee->id}}">{{$employee->f_name}} {{$employee->l_name}} </option>
                                    @endforeach
                                </select> 
        <label for="employee">Select work-agent</label>
      </div>

    </div>
    <!--Grid column-->

        <!--Grid column-->
    <div class="col-md-6 mb-4">

      <div class="md-form">
        <!--The "from" Date Picker -->
        <input placeholder="Selected starting date" type="date" name="date" id="datefield" class="form-control datepicker" required>
        <label for="startingDate">Select Date</label>
      </div>

    </div>
    <!--Grid column-->

        <div class="col-md-2 mb-4">

      <div class="md-form">
        <!--The "to" Date Picker -->
        <input class="btn btn-info" name="Filter Commission" type="submit" value="Generate Commission Report">
      </div>

    </div>

  </div>
  <!--Grid row-->
</form>
</div>


        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <section class="invoice">
                        <div class="row mb-4">
                            <div class="col-6">                            </div>
                            <div class="col-6">
                                <h5 class="text-right text-primary">Today Date : {{ date("F j, Y, g:i a") }} </h5>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-4">From
                                <address><strong>Double Cutz Spa and Kinyozi</strong><br>Email: admin@doublecutz.com</address>
                            </div>
                       
                        </div>

                                <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <section class="invoice">
                        <div class="row mb-4">
                            <div class="col-6">
                                <h3 class="page-header text-info"><i class="fa fa-head"></i> Commission Report</h3>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table">
                                    <thead>
                                    
                                    </thead>
                                    <tbody class="">
                                    <div style="display: none">
                                        {{$total=0}}
                                    </div>
                                    @foreach($employee_commission as $commission)
                                    <tr style="border-collapse:collapse;font-weight: 700;">
                                        <td colspan="2"><b class="text-muted">Name :</b> {{$commission->employee->f_name }} {{$commission->employee->l_name }}</td>
                                        <td colspan="2"><b class="text-muted">Invoice No. :</b>{{$commission->invoice_id}}</td>
                                       </tr>
                                       <tr>
                                        <th>Service</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total Amount</th>
                                     </tr>
                                       @foreach($commission->invoice->sale as $sale)        
                                       <tr>
                                        <td>{{$sale->product->name}}</td>
                                        <td>{{$sale->qty}}</td>
                                        <td>{{number_format($sale->price,2)}}</td>
                                        <td>{{number_format($sale->amount,2)}}</td>
                                     </tr>

                                       @endforeach
                                       <tr> 
                                        <td class="text-right text-info" colspan="2"><b>Earned Commission</b></td>
                                        <td class="text-right text-info" colspan="2"><b>{{number_format($commission->commission,2)}}</b></td>
                                        <div style="display: none">
                                            {{$total +=$commission->commission}}
                                        </div>
                                     </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr style="font-size: 25px;">
                                        <td></td>
                                        <td></td>
                                        <td><b>Total Commission Earned on {{ $data['selectedDate'] }}</b></td>
                                        <td><b class="total">{{number_format($total,2)}}</b></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row d-print-none mt-2">

                            <div class="col-12 text-right">
                          <!--       <form action="{{ route('stkPush') }}" method="post">

                                <button class="btn btn-success"><i class="fa fa-share"></i> Pay Via Mpesa</button>
                                </form>
 -->
                                <a class="btn btn-primary" href="javascript:window.print();"><i class="fa fa-print"></i> Print</a>
                            </div>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

@endsection
@push('js')
@endpush






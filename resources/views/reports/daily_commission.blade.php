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
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <section class="invoice">
                        <div class="row mb-4">
                            <div class="col-6">
                                <h2 class="page-header text-info"><i class="fa fa-head"></i> Commission Report</h2>
                            </div>
                            <div class="col-6">
                                <h5 class="text-right text-muted">Date: {{ Date('Y/m/d')}} </h5>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-4">From
                                <address><strong>Double Cutz Spa and Kinyozi</strong><br>Email: admin@doublecutz.com</address>
                            </div>
                       
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table">
                                    <thead>
                                    
                                    </thead>
                                    <tbody>
                                    <div style="display: none">
                                        {{$total=0}}
                                    </div>
                                    @foreach($daily_commission as $commission)
                                    <tr style="border-collapse:collapse;" class="bg-info">
                                        <td colspan="2">{{$commission->employee->f_name }} {{$commission->employee->l_name }}</td>
                                        <td colspan="2">{{$commission->invoice_id}}</td>
                                       </tr>
                                       <tr style="border: 1px solid lightseagreen!important;">
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
                                        <td class="text-right" colspan="2">Total Commission</td>
                                        <td class="text-right" colspan="2">{{number_format($commission->commission,2)}}</td>
                                        <div style="display: none">
                                            {{$total +=$commission->commission}}
                                        </div>
                                     </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr style="font-size: 40px;">
                                        <td></td>
                                        <td></td>
                                        <td><b>Total</b></td>
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






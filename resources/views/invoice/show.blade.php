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
                                <h2 class="page-header"><i class="fa fa-head"></i> Receipt</h2>
                            </div>
                            <div class="col-6">
                                <h5 class="text-right">Date: {{$invoice->created_at->format('Y-m-d')}}</h5>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-4">From
                                <address><strong>Double Cutz Spa and Kinyozi</strong><br>Email: admin@doublecutz.com</address>
                            </div>
                            <div class="col-4">To
                                 <address><strong>{{$invoice->customer->name}}</strong><br>{{$invoice->customer->address}}<br>Phone: {{$invoice->customer->mobile}}<br>Email: {{$invoice->customer->email}}</address>
                             </div>
                            <div class="col-4"><b>Invoice #{{1000+$invoice->id}}</b><br><!--<br><b>Order ID:</b> 4F3S8J<br>--><b>Payment Due:</b> {{$invoice->created_at->format('Y-m-d')}}<br><!--<b>Account:</b> 968-34567--></div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                     </tr>
                                    </thead>
                                    <tbody>
                                    <div style="display: none">
                                        {{$total=0}}
                                    </div>
                                    @foreach($sales as $sale)
                                    <tr>
                                        <td>{{$sale->product->name}}</td>
                                        <td>{{$sale->qty}}</td>
                                        <td>{{$sale->price}}</td>
                                        <td>{{$sale->amount}}</td>
                                        <div style="display: none">
                                            {{$total +=$sale->amount}}
                                        </div>
                                     </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><b>Total</b></td>
                                        <td><b class="total">{{$total}}</b></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row d-print-none mt-2">

                            <div class="col-12 text-right">
                                <form action="{{ route('stkPush') }}" method="post">

                                    <input type="hidden" name="payment_number" value="{{$invoice->customer->mobile}}" required>

                                    <input type="hidden" name="amount" value="{{ $total}}" required>

                                <button class="btn btn-success"><i class="fa fa-share"></i> Pay Via Mpesa</button>

                                    <a class="btn btn-secondary" href="javascript:window.print();"><i class="fa fa-print"></i> Print</a>
                                </form>

                                {{-- <a class="btn btn-warning" href="javascript:window.print();"><i class="fa fa-print"></i>Send STK</a> --}}
                             
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






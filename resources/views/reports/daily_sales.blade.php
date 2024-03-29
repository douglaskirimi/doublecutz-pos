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
       <form  method="POST" action="{{route('filter_sales')}}">
        @csrf
    <p><strong>Select Period to view sales</strong></p>

        <hr>
  
  <!--Grid row-->
  <div class="row">

    <!--Grid column-->
    <div class="col-md-6 mb-4">

      <div class="md-form">
        <!--The "from" Date Picker -->
        <input placeholder="Selected starting date" type="date" name="startDate" id="datefield" class="form-control datepicker" required="required">
        <label for="startingDate">Select Start Date</label>
      </div>

    </div>
    <!--Grid column-->

    <!--Grid column-->
    <div class="col-md-6 mb-4">

      <div class="md-form">
        <!--The "to" Date Picker -->
        <input placeholder="Selected ending date" type="date" name="endDate" id="datefield" class="form-control datepicker"required="required">
        <label for="endingDate">Select End Date</label>
      </div>

    </div>
    <!--Grid column-->

        <div class="col-md-2 mb-4">

      <div class="md-form">
        <!--The "to" Date Picker -->
        <input class="btn btn-info" name="Filter Sales" type="submit" value="Filter Sales">
      </div>

    </div>

  </div>
  <!--Grid row-->
</form>
</div>

 @if (session()->has('alert-success'))
    <div class="alert alert-success">
        {{ session()->get('alert-success') }}
    </div>
 @endif


        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <section class="invoice">
                        <div class="row mb-4">
                            <div class="col-6">
                                <h2 class="page-header text-info"><i class="fa fa-head text-info"></i> Today Sales</h2>
                            </div>
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
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                     </tr>
                                    </thead>
                                    <tbody>
                                    <div style="display: none">
                                        {{$total=0}}
                                    </div>
                                    @foreach($daily_sales as $sale)
                                    <tr>
                                        <td>{{$sale->product->name}}</td>
                                        <td>{{$sale->qty}}</td>
                                        <td>{{$sale->price}}</td>
                                        <td>{{$sale->amount}}</td>           
                                        <td>
                                 
                                    <a class="btn btn-primary" href="{{route('invoice.edit', $sale->invoice_id)}}"><i class="fa fa-edit" ></i></a>

                                         <button class="btn btn-danger waves-effect" type="submit" onclick="deleteTag({{ $sale->invoice->id }})">
                                             <i class="fa fa-trash-o"></i>
                                         </button>
                                         <form id="delete-form-{{ $sale->invoice->id }}" action="{{ route('invoice.destroy',$sale->invoice->id) }}" method="POST" style="display: none;">
                                             @csrf
                                             @method('DELETE')
                                         </form>
                                     </td>
                                        
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
        <script type="text/javascript">
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();

if (dd < 10) {
   dd = '0' + dd;
}

if (mm < 10) {
   mm = '0' + mm;
} 
    
today = yyyy + '-' + mm + '-' + dd;
document.getElementById("datefield").setAttribute("max", today);
        </script>

    </main>

@endsection
@push('js')
    <script type="text/javascript" src="{{asset('/')}}js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{asset('/')}}js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
    <script type="text/javascript">
        function deleteTag(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush







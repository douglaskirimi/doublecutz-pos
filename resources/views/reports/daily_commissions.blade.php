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

        <hr>
  
  <!--Grid row-->
  <div class="row">

    <!--Grid column-->
    <div class="col-md-6 mb-4">

      <div class="md-form">
                                {{-- <label class="control-label">Customer Name</label> --}}
                                <select name="employee_id" class="form-control" required>
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
        <input placeholder="Selected starting date" type="date" name="date" id="datefield" class="form-control datepicker">
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
                            <div class="col-6">
                                <h2 class="page-header text-info"><i class="fa fa-head text-info"></i> Daily Employee Commissions</h2>
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
                                        <th>Employee Name</th>
                                        <th>Invoice Number</th>
                                        <th>Commission Earned</th>
                                        {{-- <th>Action</th> --}}
                                     </tr>
                                    </thead>
                                    <tbody>
                                    <div style="display: none">
                                        {{$total=0}}
                                    </div>
                                    @foreach($daily_commission as $commission)

                                    <tr>
                                        <td class="">{{$commission->employee->f_name}} {{$commission->employee->l_name}}</td>
                                        <td>{{$commission->invoice_id}}</td>
                                        <td>{{$commission->commission}}</td>
                                         
                                        <div style="display: none">
                                            {{$total +=$commission->commission}}
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
@endpush






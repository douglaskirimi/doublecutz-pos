@extends('layouts.master')

@section('title', 'Invoice | ')
@section('content')
    @include('partials.header')
    @include('partials.sidebar')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> Form</h1>
                <p></p>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
            </ul>
        </div>


         <div class="row">
             <div class="clearix"></div>
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Invoice</h3>
                    <div class="tile-body">
                        <form  method="POST" action="{{route('receipt.store')}}" onsubmit="return validate()">
                            @csrf
                            <div class="row">
                            <div class="form-group col-md-3">
                                <label class="control-label">Customer Name</label>
                                <select name="customer_id" class="form-control" id="customer_id" required>
                                    <option>Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option name="customer_id" value="{{$customer->id}}">{{$customer->name}} </option>
                                    @endforeach
                                </select>                           
                             </div>
                             <div class="form-group col-md-3">
                                <label class="control-label">Invoice Name</label>
                                <select name="invoice_id" class="form-control" id="invoice_id" required>
                                    <option>Select Invoice</option>
                                   
                                </select>                           
                             </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Date</label>
                                <input name="date"  class="form-control datepicker"  value="<?php echo date('Y-m-d')?>" type="date" placeholder="Enter your email">
                            </div>
                            <div>
<style>
   .table-input td input{ 
        /* padding: 2px; */
        border: none;
        background-color: white !important;
    }
    .tally td,.tally-input td{ 
        padding: 2px;
        border: none;
       
    }
    .tally input{
        background-color: white !important;
        padding: 10px;
        border: none;
        
    }
</style>

                        <table class="table table-bordered" style="display:none">
                            <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Price</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Amount</th>
                              
                            </tr>
                            </thead>
                            <tbody>
                          
                            </tbody>
                            <tfoot>
                            <tr class="tally">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Total Payable</b></td>
                                <td><input type="text" class="form-control" id="total-payable" readonly value="0"/></td>
                               
                            </tr>
                            <tr class="tally">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Paid Amount</b></td>
                                <td class="total"><input type="text" class="form-control" id="paid" value="0" readonly/></b></td>
                           
                            </tr>
                            <tr class="tally">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Balance Remain</b></td>
                                <td class="total"><input type="text" class="form-control" id="balance" value="0" readonly/></b></td>
                           
                            </tr>
                            <tr class="tally-input" >
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>Pay Amount</b></td>
                                <td class="total"><input type="number" class="form-control" name="amount" style="max-width: 120px;" id="amount" value="0" autocomplete="off"/></b></td>
                           
                            </tr>
                            <tr class="tally">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b>New Balance</b></td>
                                <td class="total"><input type="text" class="form-control" id="new-balance" value="0" readonly/></b></td>
                           
                            </tr>
                            <tr></tr>
                            <tr class="tally">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <select class="form-control" name="payment-mode">
                                        <option>Select Payment Mode</option>
                                        <option>Cash </option>
                                        <option>Mpesa Mode</option>
                                        <option>Cheque </option>
                                        <option>Bank Mode</option>
                                        
                                    </select>
                            </td>
                                <td class="total">  <button class="btn btn-primary" style="width:150px" type="submit">Submit</button></td>
                           
                            </tr>
                           
                            </tfoot>
                            

                        </table>

                           
                     </form>
                    </div>
                </div>


                </div>
            </div>







    </main>

@endsection
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
     <script src="{{asset('/')}}js/multifield/jquery.multifield.min.js"></script>




    <script type="text/javascript">
        $(document).ready(function(){

            $('body').delegate('#amount', 'keyup', function () {
               var amount= $('#amount').val();
               var balance= $('#balance').val();
               if((balance-amount)<0){
                $('#new-balance').val("NAN");
               }
            else{
                $('#new-balance').val(balance-amount);
            }
             
              //  alert($('#amount').val())
            })
            $('body').delegate('#invoice_id', 'change', function () {
                var id=($("#invoice_id :selected").val())
                var customer=($("#customer_id :selected").val())
              //  $("#invoice_id").html(" <option>Select Invoice</option>");
            
                if(id!=="Select Customer"){

                $.ajax({
                    type    : 'GET',
                    url     :'{!! URL::route('findInvoice') !!}',

                    dataType: 'json',
                    data: {"_token": $('meta[name="csrf-token"]').attr('content'), 'id':id,'customer':customer},
                    success:function (data) {
                        //data = JSON.parse(data);
                     //   console.log(data['sale']);
                     $('tbody').html("");
                        data.invoice.sale.forEach(function(sales){
                            $("table").css("display","block")
                            var addRow = '<tr class="table-input">\n' 
                            +
                        '        <td><input type="text" value="'+sales.product.name+'" class="form-control qty" readonly></td>\n' +
'                                <td><input type="text"  value="'+sales.qty+'" class="form-control qty" readonly></td>\n' +
'                                <td><input type="text" value="'+sales.price+'" class="form-control price" readonly></td>\n' +
'                                <td><input type="text"  value="'+sales.dis+'" class="form-control dis" readonly></td>\n' +
'                                <td><input type="text"   value="'+sales.amount+'"  class="form-control amount" readonly></td>\n' +

'                             </tr>';
                         $('tbody').append(addRow);

                        })
                        $('#total-payable').val(data.total);
                        $('#balance').val(data.balance);
                        $('#paid').val(data.paid);
                        $('#amount').attr({min:0,
                            'max':data.balance})
                        $('#new-balance').val(data.balance);
                        
                        // data.forEach(function (val){
                        //     $("#invoice_id").append("<option value="+val.id+">"+val.id+"</option");

                        // })
                        // console.log(data)
                        // tr.find('.price').val(data.sales_price);
                        // tr.find('.price').change()
                        // if(data.sales_price>0){
                        //     tr.find('.price').css("pointer-events","none")
                        // }else{
                        //     tr.find('.price').css("pointer-events","")
                        // }
                      
                    }
                });
            }
            })

            $('body').delegate('#customer_id', 'change', function () {
                var id=($("#customer_id :selected").val())
                $("table").css("display","none")
                $("#invoice_id").html(" <option>Select Invoice</option>");
                if(id!=="Select Customer"){
                $.ajax({
                    type    : 'GET',
                    url     :'{!! URL::route('invoices') !!}',

                    dataType: 'json',
                    data: {"_token": $('meta[name="csrf-token"]').attr('content'), 'id':id},
                    success:function (data) {

                        data.forEach(function (val){
                            $("#invoice_id").append("<option value="+val.id+">"+val.id+"</option");

                        })
                        // console.log(data)
                        // tr.find('.price').val(data.sales_price);
                        // tr.find('.price').change()
                        // if(data.sales_price>0){
                        //     tr.find('.price').css("pointer-events","none")
                        // }else{
                        //     tr.find('.price').css("pointer-events","")
                        // }
                      
                    }
                });
            }

            })

            $('tbody').delegate('.productname', 'change', function () {

                var tr =$(this).parent().parent();
                var id = tr.find('.productname').val();
                var dataId = {'id':id};
                $.ajax({
                    type    : 'GET',
                    url     :'{!! URL::route('findPrice') !!}',

                    dataType: 'json',
                    data: {"_token": $('meta[name="csrf-token"]').attr('content'), 'id':id},
                    success:function (data) {
                        tr.find('.price').val(data.sales_price);
                        tr.find('.price').change()
                        if(data.sales_price>0){
                            tr.find('.price').css("pointer-events","none")
                        }else{
                            tr.find('.price').css("pointer-events","")
                        }
                      
                    }
                });
            });

            $('tbody').delegate('.qty,.price,.dis', 'change', function () {

                var tr = $(this).parent().parent();
                var qty = tr.find('.qty').val();
                var price = tr.find('.price').val();
                var dis = tr.find('.dis').val();
                var amount = (qty * price)-(qty * price * dis)/100;
                tr.find('.amount').val(amount);
                total();
            });
            function total(){
                var total = 0;
                $('.amount').each(function (i,e) {
                    var amount =$(this).val()-0;
                    total += amount;
                })
                $('.total').html(total);
            }

            $('.addRow').on('click', function () {
                addRow();

            });

            function addRow() {
                var addRow = '<tr>\n' +
                    '         <td><select name="product_id[]" class="form-control productname " >\n' +
                    '         <option value="0" selected="true" disabled="true">Select Product</option>\n' +
'                                        @foreach($products as $product)\n' +
'                                            <option value="{{$product->id}}">{{$product->name}}</option>\n' +
'                                        @endforeach\n' +
                    '               </select></td>\n' +
'                                <td><input type="number" name="qty[]" value="1" class="form-control qty" ></td>\n' +
'                                <td><input type="number" name="price[]" class="form-control price" ></td>\n' +
'                                <td><input type="number" name="dis[]" value="0" class="form-control dis" ></td>\n' +
'                                <td><input type="text" name="amount[]" value="0"  class="form-control amount" readonly></td>\n' +
'                                <td><a   class="btn btn-danger remove"> <i class="fa fa-remove"></i></a></td>\n' +
'                             </tr>';
                $('tbody').append(addRow);
            };


            $('.remove').live('click', function () {
                var l =$('tbody tr').length;
                if(l==1){
                    alert('you cant delete last one')
                }else{

                    $(this).parent().parent().remove();

                }

            });
        });


    </script>

@endpush




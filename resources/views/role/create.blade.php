@extends('layouts.master')

@section('title', 'Tax | ')
@section('content')
@include('partials.header')
@include('partials.sidebar')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-edit"></i>role</h1>
            <p></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Forms</li>
            <li class="breadcrumb-item"><a href="#">role</a></li>
        </ul>
    </div>

    @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif

    <div class="">
        <a class="btn btn-primary" href="{{route('role.index')}}"><i class="fa fa-edit"> role </i></a>
    </div>
    <div class="row mt-2">

        <div class="clearix"></div>
        <div class="col-md-10">
            <div class="tile">
                <h3 class="tile-title">role</h3>
                <div class="tile-body">
                    <form method="POST" action="{{route('role.store')}}">
                        @csrf
                        <div class="form-group col-md-8">
                            <label class="control-label">Role Name</label>
                            <input name="name" class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Enter Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-8">
                            <label class="control-label">Permissions</label>
                            <table class="table table-striped">
                                <thead>
                                    <th>Module</th>
                                    <th>Can View</th>
                                    <th>Can Edit</th>
                                    <th>Can Update</th>
                                    <th>Can Delete</th>
                                </thead>
                                @foreach($modules as $module)
                                <tbody>
                                    <tr>
                                        <td><input name="module_id[]" type="hidden" value="{{$module->id}}">{{$module->name}}</td>
                                        <td>
                                            <input type="checkbox"  class="form-control checkbox" />
                                            <input name="can_view[]"  class="form-control input" type="hidden" value="0">
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-control checkbox" />
                                            <input name="can_create[]" class="form-control input" type="hidden" value="0">
                                        </td>
                                        <td>
                                            <input type="checkbox"  class="form-control checkbox" />
                                            <input name="can_update[]" class="form-control input" type="hidden" value="0">
                                        </td>
                                        <td>
                                            <input type="checkbox"  class="form-control checkbox" />
                                            <input name="can_delete[]" class="form-control input" type="hidden" value="0">
                                        </td>

                                    </tr>
                                </tbody>
                                @endforeach

                            </table>

                        </div>


                        <!-- <div class="form-group col-md-8">
                                <label class="control-label">Previous Credit Balance</label>
                                <input name="previous_balance" class="form-control @error('previous_balance') is-invalid @enderror" type="text" placeholder="Enter Unit Name">
                                @error('previous_balance')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> -->


                        <div class="form-group col-md-4 align-self-end">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>
                        </div>
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
    $(document).ready(function() {



         
                $('tbody').delegate('.checkbox', 'change', function() {

                    var tr = $(this).parent();
                    var id = tr.find('.input').val();
                    if(id=="1"){
                        tr.find('.input').val(0);
                    }else{
                        tr.find('.input').val(1)
                    }
                    console.log(id)
                });
            });
</script>

@endpush
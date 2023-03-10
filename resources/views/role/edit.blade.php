@extends('layouts.master')

@section('title', 'Tax | ')
@section('content')
    @include('partials.header')
    @include('partials.sidebar')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> Role</h1>
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

        <div class="row">
            <div class="clearix"></div>
            <div class="col-md-10">
                <div class="tile">
                    <h3 class="tile-title">role</h3>
                    <div class="tile-body">
                        <form class="row" method="POST" action="{{route('role.update', $role->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group col-md-8">
                                <label class="control-label">Role Name</label>
                                <input value="{{ $role->name }}" name="name" class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Enter Unit Name">
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
                               
                                @foreach($permissions as $permission)
                                <tbody>
                                    <tr>
                                        <td><input name="module_id[]" type="hidden" value="{{$permission->module_id}}">{{$permission->module->name}}</td>
                                        <td>
                                            <input type="checkbox"  class="form-control checkbox" {{$permission->can_view?"checked":""}}/>
                                            <input name="can_view[]"  class="form-control input" type="hidden" value="{{$permission->can_view}}" >
                                        </td>
                                        <td>
                                            <input type="checkbox" class="form-control checkbox" {{$permission->can_create?"checked":""}}/>
                                            <input name="can_create[]" class="form-control input" type="hidden" value="{{$permission->can_create}}">
                                        </td>
                                        <td>
                                            <input type="checkbox"  class="form-control checkbox" {{$permission->can_update?"checked":""}}/>
                                            <input name="can_update[]" class="form-control input" type="hidden" value="{{$permission->can_update}}">
                                        </td>
                                        <td>
                                            <input type="checkbox"  class="form-control checkbox" {{$permission->can_delete?"checked":""}}/>
                                            <input name="can_delete[]" class="form-control input" type="hidden" value="{{$permission->can_delete}}">
                                        </td>

                                    </tr>
                                </tbody>
                                @endforeach

                            </table>

                        </div>

                            <!-- <div class="form-group col-md-8">
                                <label class="control-label">Role Credit Balance</label>
                                <input value="{{ $role->previous_balance }}" name="previous_balance" class="form-control @error('previous_balance') is-invalid @enderror" type="text" placeholder="Enter Unit Name">
                                @error('previous_balance')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> -->
                            <div class="form-group col-md-4 align-self-end">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
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


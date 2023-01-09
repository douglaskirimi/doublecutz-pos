@extends('layouts.master')

@section('title', 'Tax | ')
@section('content')
    @include('partials.header')
    @include('partials.sidebar')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-edit"></i> user</h1>
                <p></p>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item"><a href="#">user</a></li>
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
                    <h3 class="tile-title">user</h3>
                    <div class="tile-body">
                        <form class="row" method="POST" action="{{route('user.update', $user->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group col-md-8">
                                <label class="control-label">First Name</label>
                                <input name="f_name" value="{{$user->f_name}}" class="form-control @error('f_name') is-invalid @enderror" type="text" placeholder="Enter Name">
                                @error('f_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label class="control-label">Last Name</label>
                                <input name="l_name" value="{{$user->l_name}}" class="form-control @error('l_name') is-invalid @enderror" type="text" placeholder="Enter last name">
                                @error('l_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label class="control-label">Email Address</label>
                                <input name="email" value="{{$user->email}}" class="form-control @error('email') is-invalid @enderror" type="text" placeholder="Enter email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label class="control-label">Role </label>
                                <select class="form-control" name="role_id">
                                    <option>Select Role </option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" {{($user->role->id==$role->id)?'selected':''}}>{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- <div class="form-group col-md-8">
                                <label class="control-label">User Credit Balance</label>
                                <input value="{{ $user->previous_balance }}" name="previous_balance" class="form-control @error('previous_balance') is-invalid @enderror" type="text" placeholder="Enter Unit Name">
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




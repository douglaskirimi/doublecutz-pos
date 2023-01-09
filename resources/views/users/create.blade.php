@extends('layouts.master')

@section('title', 'Tax | ')
@section('content')
    @include('partials.header')
    @include('partials.sidebar')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-home"></i>Employee</h1>
                <p></p>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Add </li>
                <li class="breadcrumb-item"><a href="#">Employee</a></li>
            </ul>
        </div>

        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="">
            <a class="btn btn-primary" href="{{route('user.index')}}"><i class="fa fa-edit"> Manage Employees </i></a>
        </div>
        <div class="row mt-2">

            <div class="clearix"></div>
            <div class="col-md-10">
                <div class="tile">
                    <h3 class="tile-title">User</h3>
                    <div class="tile-body">
                        <form method="POST" action="{{route('user.store')}}">
                            @csrf
                            <div class="form-group col-md-8">
                                <label class="control-label">Full Name</label>
                                <input name="f_name" class="form-control @error('f_name') is-invalid @enderror" type="text" placeholder="First Name">
                                @error('f_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                <div class="form-group col-md-8">
                                <label class="control-label">Second Name</label>
                                <input name="l_name" class="form-control @error('l_name') is-invalid @enderror" type="text" placeholder="Second Name">
                                @error('l_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                    
                            <div class="form-group col-md-8">
                                <label class="control-label">Email Address</label>
                                <input name="email" class="form-control @error('email') is-invalid @enderror" type="text" placeholder="Enter email">
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
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @error('details')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        <div class="form-group col-md-8">
                                <label class="control-label">Password</label>
                                <input name="password" class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Enter Password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

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




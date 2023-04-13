@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        
    </div>

    <div class="row mt-5 " >
        <div class="col-md-6">
            <a href="/note">
                <button class="btn btn-primary col-12">HALAMAN NOTE</button>
            </a>
        </div>
        <div class="col-md-6">
            
            <button class="btn btn-primary col-12">HALAMAN TO DO LIST</button>
        </div>
    </div>
    
    
</div>
@endsection

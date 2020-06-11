@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">
                    {{ __('404 not found') }}
                </div>

                <div class="card-body">
                    {{ __('The page you requested, does not exist...') }}
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

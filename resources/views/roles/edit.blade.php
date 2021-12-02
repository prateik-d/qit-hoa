@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update State</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('state.update',$state->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="state" class="form-label">State</label>
                        <input value="{{ $state->state }}" type="text" class="form-control" name="state" placeholder="State" required>

                        @if ($errors->has('state'))
                            <span class="text-danger text-left">{{ $errors->first('state') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class='pull-right'>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('states') }}" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
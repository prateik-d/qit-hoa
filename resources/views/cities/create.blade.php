@extends('layouts.master')

@section('content')
<div class="container">
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add city</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('city.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="city" class="form-label">City</label>
                        <input value="{{ old('city') }}" type="text" class="form-control" name="city" placeholder="city" required>

                        @if ($errors->has('city'))
                            <span class="text-danger text-left">{{ $errors->first('city') }}</span>
                        @endif
                    </div>
                    <div class='form-group'>
                        <select class="form-control" name="state_id">
                            <option>Select State</option>
                            @foreach ($states as $key => $value)
                                <option value="{{ $key }}"> 
                                    {{ $value }} 
                                </option>
                            @endforeach    
                        </select>
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
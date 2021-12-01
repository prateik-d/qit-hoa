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
                    <form method="POST" action="{{ route('heading.update',$heading->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="heading" class="form-label">Title</label>
                        <input value="{{ $heading->heading }}" type="text" class="form-control" name="heading" placeholder="Title" required>

                        @if ($errors->has('heading'))
                            <span class="text-danger text-left">{{ $errors->first('heading') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="type" class="form-label">Is visible</label>
                        <?php 
                            $checked = '';
                            if($heading->status == 1) {
                                $checked = 'checked';
                            }
                        ?>
                        <input type="checkbox" name="status"<?php echo $checked;?>>
                        @if ($errors->has('status'))
                            <span class="text-danger text-left">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class='pull-right'>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('headings') }}" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
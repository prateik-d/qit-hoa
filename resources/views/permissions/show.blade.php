@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Permission</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('permission.update',$permission->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="type" class="form-label">Label</label>
                        <input value="{{ $permission->type }}" type="text" class="form-control" name="type" placeholder="Permission" required>

                        @if ($errors->has('type'))
                            <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="type" class="form-label">Is visible</label>
                        <?php 
                            $checked = '';
                            if($permission->status == 1) {
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
                            <a href="{{ route('permissions') }}" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
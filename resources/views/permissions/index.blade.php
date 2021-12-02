@extends('layouts.master')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Permissions</h4>
                    <div class="pull-right">
                        <a href="{{ route('permission.add') }}" class='btn btn-primary btn-sm'>Add</a>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Label</th>
                                <th>Heading</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $per)
                            <tr>
                                <td>{{ $per->id }}</td>
                                <td>{{ $per->type }}</td>
                                <td>{{ $per->permission_heading->heading }}</td>
                                <?php 
                                    if($per->status==1)  {
                                        $status = 'active';
                                    } else {
                                        $status = 'inactive';
                                    }
                                ?>
                                <td>{{ $status }}</td>
                                <td>
                                    <a href="{{ route('permission.edit',$per->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('permission.destroy', $per->id)}}" method="post">
                                        @csrf
                                        <input class="btn btn-danger btn-sm" type="submit" value="Delete" />
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

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
                    <h4>Roles</h4>
                    <div class="pull-right">
                        <a href="{{ route('role.add') }}" class='btn btn-primary btn-sm'>Add</a>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->role }}</td>
                                <td>
                                    <a href="{{ route('role.edit',$role->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('role.destroy', $role->id)}}" method="post">
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

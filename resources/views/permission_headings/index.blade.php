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
                    <h4>Headings</h4>
                    <div class="pull-right">
                        <a href="{{ route('heading.add') }}" class='btn btn-primary btn-sm'>Add</a>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($headings as $i=>$permission_heading)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $permission_heading->heading }}</td>
                                <?php 
                                    if($permission_heading->status==1)  {
                                        $status = 'active';
                                    } else {
                                        $status = 'inactive';
                                    }
                                ?>
                                <td>{{ $status }}</td>
                                <td>
                                    <a href="{{ route('heading.edit',$permission_heading->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('heading.destroy', $permission_heading->id)}}" method="post">
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

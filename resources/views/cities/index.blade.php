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
                    <h4>States</h4>
                    <div class="pull-right">
                        <a href="{{ route('city.add') }}" class='btn btn-primary btn-sm'>Add</a>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cities as $i=>$city)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $city->city }}</td>
                                <td>{{ $city->state->state }}</td>
                                <td>
                                    <a href="{{ route('city.edit',$city->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('city.destroy', $city->id)}}" method="post">
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

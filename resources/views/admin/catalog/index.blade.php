@extends('layouts.admin')
@section('header', 'Catalog')

@section('content')
  <div id="controller">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('catalogs/create') }}" class="btn btn-sm btn-primary pull-right">Create New Catalog</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Total Books</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catalogs as $key => $catalog)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $catalog->name }}</td>
                                    <td class="text-center">{{ count($catalog->books) }}</td>
                                    <td class="text-center">{{ convert_date($catalog->created_at) }}</td>
                                    <td class="text-center">
                                        <a href="{{ url('catalogs/' . $catalog->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ url('catalogs', ['id' => $catalog->id]) }}" method="post">
                                            <input class="btn btn-danger btn-sm" type="submit" value="delete"
                                                onclick="return confirm ('Are you sure')">
                                            @method('delete')
                                            @csrf
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

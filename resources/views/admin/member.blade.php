@extends('layouts.admin')
@section('header', 'Member')

@section('css')
{{-- datatables --}}
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


@endsection

@section('content')
<div id="controller">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">
                    <a href="#" @click="addData()" class="btn btn-sm btn-primary pull-right">Create New Member</a>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="gender">
                        <option value="0">Semua Jenis Kelamin</option>
                        <option value="P">Perempuan</option>
                        <option value="L">Laki Laki</option>
                    </select>                
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="datatable" class= "table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 30px">#</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" :action="!editStatus ? actionUrl : actionUrl + '/' + data.id" autocomplete="off" @submit="submitForm">
                    <div class="modal-header">

                        <h4 class="modal-title">Publisher</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <input type="hidden" name="_method" value="POST" v-if="editStatus">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" :value="data.name" required="">
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            {{-- <input type="text" class="form-control" name="gender" :value="data.gender" required=""> --}}
                            <select class="form-control" name="gender" :value="data.gender" required="">
                                {{-- <option value="0">Semua Jenis Kelamin</option> --}}
                                <option value="P">Laki Laki</option>
                                <option value="L">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" :value="data.phone_number"
                                required="">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" :value="data.address" required="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" :value="data.email" required="">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
{{-- yajra datatable --}}
<script type="text/javascript">
    var actionUrl = '{{ url ('members') }}';
    var apiUrl = '{{ 'api/members' }}';

    var columns = [
        {data: 'DT_RowIndex', class: 'text-center', orderable:true},
        {data: 'name', class: 'text-center', orderable:true},
        {data: 'gender', class: 'text-center', orderable:true},
        {data: 'phone_number', class: 'text-center', orderable:false},
        {data: 'address', class: 'text-center', orderable:true},
        {data: 'email', class: 'text-center', orderable:false},
        {data: 'created_at', class: 'text-center', orderable:false},
        {render: function(index, row, data, meta){
            return `
                <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">Edit</a>
                <a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">Delete</a>
                `;
        }, ordertable:false, width:'100px', class: 'text-center'},
    ];
</script>
<script src="{{ asset('js/data.js') }}"></script>
<script type="text/javascript">
    $('select[name=gender]').on('change', function() {
        gender = $('select[name=gender]').val();
       
        if (gender == 0) {
            controller.table.ajax.url(actionUrl).load();
        }else {
            controller.table.ajax.url(actionUrl+'?gender='+gender).load();
        }
    });
</script>
@endsection


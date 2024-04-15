@extends('layouts.admin')

@section('header', 'Peminjaman')

@section('css')
<!-- Jquery UI -->
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
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
        <div class="col-md-8">
          <a href="{{ url('transactions/create') }}" class="btn btn-primary btn-sm">Tambah Transaksi</a>
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-6">
              <select class="form-control form-control-sm" name="status">
                <option value="semua">Semua Status</option>
                <option value="belum">Belum Dikembalikan</option>
                <option value="sudah">Sudah Dikembalikan</option>
              </select>
            </div>
            <div class="col-md-6">
              <input class="form-control form-control-sm" id="datepicker" name="date_start" type="text" placeholder="Filter Tanggal Pinjam">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table id="datatable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>       
            <th>Nama Peminjman</th>
            <th>Lama Pinjam</th>
            <th>Total Buku</th>
            <th>Total Bayar</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
      </table> 
    </div>
  </div>
</div>
@endsection

@section('js')
<!-- Jquery UI -->
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
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
<script type="text/javascript">
  var apiUrl = '{{ url('api/transactions') }}';
  var actionUrl = '{{ url('transactions') }}';
  
  var columns = [
    {data: 'DT_RowIndex', class: 'text-center', orderable: 'false'},
    {data: 'date_start', class: 'text-center', orderable: 'false'},
    {data: 'date_end', class: 'text-center', orderable: 'false'},
    {data: 'member_id', class: 'text-center', orderable: 'false'},
    {data: 'lama_pinjam', class: 'text-center', orderable: 'false'},
    {data: 'total_buku', class: 'text-center', orderable: 'false'},
    {data: 'total_bayar', class: 'text-center', orderable: 'false'},
    {data: 'status', class: 'text-center', orderable: 'false'},
    {render: function(index, row, data, meta) { 
        return `<div class="d-flex justify-content-center">
                  <a href="{{ url('/transactions/${data.id}/edit') }}" class="btn btn-warning btn-sm mr-1">Edit</a> 
                  <a href="{{ url('/transactions/${data.id}') }}" class="btn btn-info btn-sm mr-1">Detail</a> 
                  <form action="{{ url('/transactions/${data.id}') }}" method="POST">
                    {{ method_field('delete') }} {{  csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                      Delete
                    </button>
                  </form>
                </div>`;
      }, orderable: false, width: '200px', class: 'text-center' },
  ];

  $(function() {
    $('#datepicker').datepicker({ dateFormat: 'dd MM yy' }).val();
  });
</script>
<script src="{{ asset('js/data.js') }}"></script>
<script type="text/javascript">
  // filter status
  $('select[name=status]').on('change', function(){
    status = $('select[name=status]').val();
    if(status == 'semua'){
      controller.table.ajax.url(apiUrl).load();
    } else {
      controller.table.ajax.url(apiUrl+'?status='+status).load();
    }
  });

  // filter tanggal
  $('input[name=date_start]').on('change', function(){
    date_start = $('input[name=date_start]').val();
    controller.table.ajax.url(apiUrl+'?date_start='+date_start).load();
  });
</script>
  @if(Session::has('success'))
  <script>
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "timeOut": "15000"
    } 
    toastr.success("{{ session('success') }}");
  </script>
  @endif
  @if(Session::has('warning'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "15000"
        }
        toastr.error("{{ session('warning') }}");
    </script>
    @endif
@endsection

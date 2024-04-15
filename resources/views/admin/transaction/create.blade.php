@extends('layouts.admin')

@section('header', 'Peminjaman')

@section('css')
<!-- Jquery UI -->
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<style>
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007BFF;
    border: 1px solid #007BFF;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: rgba(240, 52, 52, .8);
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #FF0000; 
  }

  .select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #80bdff;
  }

  input.form-control:read-only {
    background-color: #fff;
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-md-8 mx-auto">

    @if($errors->any())
    <div class="alert bg-danger alert-dismissible fade show" role="alert">
      @foreach ($errors->all() as $error)
        {{ $error }} <br>
      @endforeach
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    <form action="{{ url('transactions') }}" method="post" onsubmit="return confirm('Are you sure?')">
      @csrf
      <div class="card card-primary"> 
        <div class="card-header">
          <h3 class="card-title">Tambah Peminjaman</h3>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Anggota</label>
            <div class="col-md-9">
              <select name="member_id" class="form-control" required>
                <option selected disabled value="">Pilih Anggota</option>
                @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Tanggal</label>
            <div class="col-md-9">
              <div class="row">
                <div class="col-md-6">
                  <input class="form-control" id="date_start" name="date_start" type="text" placeholder="Tanggal Pinjam" required>
                </div>
                <div class="col-md-6">
                  <input class="form-control" id="date_end" name="date_end" type="text" placeholder="Tanggal Kembali" required>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Buku</label>
            <div class="col-md-9">
              <select name="books_id[]" class="select2 form-control" multiple="multiple" data-placeholder="Pilih Buku" style="width: 100%;" required>
                @foreach($books as $book)
                <option value="{{ $book->id }}">{{ $book->title }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary float-right">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('js')
<!-- Jquery UI -->
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
  $(function() {
    $("#date_start").datepicker({
        dateFormat: "dd MM yy", 
        minDate:  0, // nonaktifkan tanggal sebelum tanggal saat ini
        onSelect: function(date){
            //  nonaktifkan tanggal setelah nilai date_start dipilih
            var date2 = $('#date_start').datepicker('getDate');
            date2.setDate(date2.getDate()+1);
            $('#date_end').datepicker('option', 'minDate', date2);
        }
    });
    $('#date_end').datepicker({
        dateFormat: "dd MM yy", 
    });

    //Initialize Select2 Elements
    $('.select2').select2();
  });
</script>
@endsection
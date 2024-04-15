@extends('layouts.admin')

@section('header', 'Pemnjaman')

@section('content')
<div class="row">
  <div class="col-md-8 mx-auto">
  <form action="{{ url('transactions/'.$transaction->id) }}" method="post" onsubmit="return confirm('Are you sure?')">
    @csrf
    {{ method_field('PUT') }}
    <div class="card card-warning"> 
      <div class="card-header">
        <h3 class="card-title">Edit Peminjaman</h3>
      </div>
      <div class="card-body">
        <div class="form-group row">
          <label class="col-md-3">Anggota</label>
          <div class="col-md-9">
            <input class="form-control" readonly value="{{ $transaction->member->name }}">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3">Tanggal</label>
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-6">
                <input class="form-control" readonly value="{{ convert_date($transaction->date_start) }}">
              </div>
              <div class="col-md-6">
                <input class="form-control" readonly value="{{ convert_date($transaction->date_end) }}">
              </div>
            </div>
          </div>
          <div class="col-md-9">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3">Buku</label>
          <div class="col-md-9">
            <select multiple class="form-control" disabled>
              @foreach($transaction->transaction_details as $transaction_detail)
              <option>{{ $transaction_detail->book->title }} - {{ convert_rupiah($transaction_detail->book->price) }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3">Status</label>
          <div class="col-md-9">
            <div class="form-check">
              <input id="status" class="form-check-input" type="checkbox" name="status" value="1" required>
              <label  for="status" class="form-check-label">Sudah Dikembalikan</label>
            </div>
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
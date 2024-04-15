@extends('layouts.admin')

@section('header', 'Peminjaman')

@section('content')
<div class="row">
  <div class="col-md-8 mx-auto">
    <div class="card card-info"> 
      <div class="card-header">
        <h3 class="card-title">Detail Peminjaman</h3>
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
            <input class="form-control" readonly value="{{ $transaction->status == 0 ? 'Belum Dikembalikan' : 'Sudah Dikembalikan' }}">
          </div>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ url('/transactions') }}" class="btn btn-secondary float-right">Close</a>
      </div>
    </div>
  </div>
</div>
@endsection
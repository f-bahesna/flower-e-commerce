@extends('layouts.user.appUser')

@section('title', 'Konfirmasi Pembayaran')
  <!-- Page Content -->

@section('content')
    <div class="card" style="min-height: 200px">
        <div class="card-header">
            <h4>Upload Bukti Pembayaran Disini</h4>
        </div>
        <div class="card-body">
            <input type="file" name="imageUpload" id="imageUpload">
            <img height="200" width="400" src="#" alt="Image Preview" id="imagePreview">
        </div>
        <div class="row ml-2">
            <div class="col-md-6">
                <label for="nomor-telepon">Nomor Telepon</label>
                <input type="text" class="form-control" placeholder="Masukan Nomor Telepon">
                <span class="text-danger mt-3">*Nomor Telepon Harus Sesuai dengan Nomor yang di input sewaktu Checkout</span>
            </div>
        </div>
        <button class="btn btn-lg btn-success disabled">Upload</button>
    </div>
@endsection
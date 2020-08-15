@extends('layouts.admin.appAdmin')
@section('title','Product')
@section('content')
<table id="table-product" class="table table-hover table-striped table-sm">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Product</th>
        <th>Gambar</th>
        <th>Jenis</th>
        <th>Umur</th>
        <th>Berat</th>
        <th>Stock</th>
        <th>Keterangan</th>
        <th>Status</th>
        <th>Created At</th>
        <th>Created By</th>
        <th>Setting</th>
      </tr>
    </thead>
    <tbody>
      @if($dataProducts)
      @php($i = 1)
        @foreach ($dataProducts as $key =>  $item)
          <tr>
            <input type="hidden" class="product-id" value="{{ $item->id }}">
            <td>{{ $i++ }}</td>
            <td>{{ $item->nama_product }}</td>
            <td>
              <img src="{{ url('storage/image/'.$item->gambar_product) }}" height="200" width="200" alt="">
            </td>
            <td>{{ $item->jenis_product }}</td>
            <td>{{ $item->umur_product }} Bln</td>
            <td>{{ $item->berat_product }}g</td>
            <td>{{ $item->stock_product }}</td>
            <td>{{ $item->keterangan_product }}</td>
            <td> 
            @if($item->status_product == 'published')
              <button type="button" class="btn btn-success btn-change btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ ucfirst($item->status_product) }}
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item change-publish" status="draft" href="#">Drafted</a>
                <a class="dropdown-item change-publish" status="publish" href="#">Publish</a>
              </div>
            @else
            <button type="button" class="btn btn-warning btn-change btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ ucfirst($item->status_product) }}
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item change-publish" status="publish" href="#">Publish</a>
              <a class="dropdown-item change-publish" status="draft" href="#">Drafted</a>
            </div>
            @endif
            </td>
            <td>{{ $item->created_at }}</td>
            <td>{{ $item->created_by }}</td>
            <td> 
              <a href="{{ route('get.detail.product',["id"=> $item->id]) }}"><button class="btn btn-warning btn-sm"><i class="fas fa-2x fa-edit"></i></button></a>
              <input type="hidden" value="{{ $item->id }}">
              <a href="#"><button class="btn mt-2 btn-danger btn-delete-product btn-sm"><i class="fas fa-2x fa-trash"></i></button></a>
            </td>
          </tr>
        @endforeach
    </tbody>
    @else
    <tr>
      <td>Data Kosong</td>
    </tr>
    @endif
  </table>
@endsection
@extends('layouts.admin.appAdmin')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
      <h2>Order Manual</h2>
      <div class="card border-warning">
        <div class="card-body">
          <table id="table-product" class="table table-hover table-striped table-sm">
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor Telephone</th>
                <th>Status</th>
                <th>City</th>
                <th>Product</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              @if($orders_manual)
              @php($i = 1)
                @foreach ($orders_manual as $key =>  $item)
                  <tr>
                    <input type="hidden" class="apn-order-code" value="{{ $item->order_code }}">
                    <input type="hidden" class="apn-address" value="{{ $item->address }}">
                    <input type="hidden" class="apn-province" value="{{ $item->province }}">
                    <input type="hidden" class="apn-courier" value="{{ $item->courier }}">
                    <input type="hidden" class="apn-courier-service" value="{{ $item->courier_service }}">
                    <input type="hidden" class="apn-courier-price" value="{{ $item->courier_price }}">
                    <input type="hidden" class="apn-total-price" value="{{ $item->total_price }}">
                    <input type="hidden" class="apn-notes" value="{{ $item->notes }}">
                    
                    <input type="hidden" class="apn-nama-product" value="{{ $item->nama_product }}">
                    <input type="hidden" class="apn-jenis-product" value="{{ $item->jenis_product }}">
                    <input type="hidden" class="apn-harga-product" value="{{ $item->harga_product }}">
                    <input type="hidden" class="apn-berat-product" value="{{ $item->berat_product }}">
                    <input type="hidden" class="apn-payment-confirmation-image" src="{{ asset('storage/paymentConfirmation/'. $item->image) }}">

                    <input type="hidden" class="order_id" value="{{ $item->id_order }}">
                    <td>{{ $i++ }}</td>
                    <td class="apn-nomor-telephone">{{ $item->nomor_telephone }}</td>
                    @switch($item->status)
                      @case('waiting')
                    <td><h6><span class="badge badge-warning">{{ $item->status }}</span></h6></td>
                      @break
                      @case('cancel_process')
                    <td><h6><span class="badge badge-danger">{{ $item->status }}</span></h6></td>
                      @break
                      @case('packing')
                    <td><h6><span class="badge badge-info">{{ $item->status }}</span></h6></td>
                      @break
                      @case('shipping')
                    <td><h6><span class="badge badge-info">{{ $item->status }}</span></h6></td>
                      @break
                      @case('done')
                    <td><h6><span class="badge badge-success">{{ $item->status }}</span></h6></td>
                      @break
                      @default
                    <td><h6><span class="badge">{{ $item->status }}</span></h6></td>
                      @endswitch
                    <td class="apn-city">{{ $item->city }}</td>
                    <td class="apn-nama-product">{{ $item->nama_product }}</td>
                    <td class="apn-qty">{{ $item->qty }}</td>
                  </tr>
                @endforeach
            </tbody>
            @else
            <tr>
              <td>Data Kosong</td>
            </tr>
            @endif
          </table>
        </div>
      </div>



          <!-- Modal -->
          <div class="modal fade" id="exampleModalCenter" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Detail Order</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                            <h6 class="text-center text-dark">Payment Details</h6>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                            <h6 class="text-center text-dark">Product Details</h6>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                            <h6 class="text-center text-dark">Address & Courier</h6>
                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body payment-confirmation" id="zoom-image">
                          <p class="font-weight-bold text-muted modal-order-code">Error</p>
                          <img class="modal-image-payment-confirmation" height="250" width="300" alt="">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body">
                          <p class="font-weight-normal modal-nama-product">Nama Product : </p>
                          <p class="font-weight-normal modal-jenis-product">Jenis : </p>
                          <p class="font-weight-normal modal-dipesan">Dipesan : </p>
                          <p class="font-weight-normal modal-harga-product">Harga : </p>
                          <p class="font-weight-normal modal-berat-product">Berat : 2 kg</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body">
                          <p class="font-weight-normal modal-pengiriman">Alamat Pengiriman : Jl.Suka Maju</p>
                          <p class="font-weight-normal modal-provinsi">Provinsi : Jawa Tengah</p>
                          <p class="font-weight-normal modal-city">Kota : Solo</p>
                          <hr/>
                          <p class="font-weight-normal modal-kurir">Kurir : JNE</p>
                          <p class="font-weight-normal modal-kurir-service">Kurir Servis : OKE</p>
                          <p class="font-weight-normal modal-ongkir">Biaya Ongkir : 7000</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-md-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-3">
                              <button class="btn btn-danger btn-sm btn-tolak">Tolak</button>
                            </div>
                            <div class="col-md-1">
                              <button class="btn btn-success btn-sm btn-terima">Terima</button>
                            </div>
                          </div>
                          <div class="row row-tolak">
                            <textarea class="form-control mt-2" id="textarea-tolak" placeholder="Tulis Alasan Peno" name="" id="" cols="30" rows="4"></textarea>
                            <button class="btn btn-sm btn-warning btn-cancel-tolak float-right mt-2 mr-2">cancel</button>
                              <input type="hidden" class="for-order-code-tolak" value="">
                            <button class="btn btn-sm btn-danger btn-confirm-tolak float-right mt-2">Confirm Tolak</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      {{--  --}}
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-8">
                      <div class="card">
                        <div class="card-body">
                          <textarea class="modal-notes" disabled name="" id="" cols="103" rows="10"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="row">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="text-center">Total Keseluruhan :</h4>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="text-center modal-total-price">Rp.2.000.000</h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-success">Packing</button>
                </div>
              </div>
            </div>
          </div>

    </div>
    <div class="col-md-6"></div>
  </div>
</div>


@endsection
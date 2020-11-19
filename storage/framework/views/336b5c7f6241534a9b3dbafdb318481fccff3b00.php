<?php $__env->startSection('title', 'Product Detail'); ?>
  <!-- Page Content -->
<?php $__env->startSection('content'); ?>
<div class="container" style="margin-top: 15px;">
<div class="row">
  <div class="col-md">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('home-page')); ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.all')); ?>">Product</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('jenis')); ?>">Jenis</a></li>
        <li class="breadcrumb-item" active><?php echo e($result["nama_product"]); ?></li>
      </ol>
    </nav>
  </div>
</div>
<div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-center">
              <h3><?php echo e($result["nama_product"]); ?></h3>
            </div>
          </div>
          <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active img-product-animation" data-interval="10000">
                <img src="<?php echo e(url('storage/image/'.$result["gambar_product"])); ?>" class="d-block w-100" height="400px" alt="...">
              </div>
              <?php if($additional_image != null): ?>
                <?php $__currentLoopData = $additional_image; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="carousel-item img-product-animation" data-interval="2000">
                    <img src="<?php echo e(url('storage/additional_image/'. $value->additional_product_image )); ?>" class="d-block w-100" height="400px" alt="...">
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </div>
            <a class="carousel-control-prev carousel-part" href="#carouselExampleInterval" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next carousel-part" href="#carouselExampleInterval" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header justify-content-center">
              Deskripsi Product 
            </div>
            <div class="card-body">
              <h4 class="font-weight-bold"> RP. <?php echo e(number_format($result["harga_product"],0,',','.')); ?></h4>
              <hr/>
              <h6>Umur : <?php echo e($result["umur_product"]); ?> Bulan</h6>
              <h6>Jenis : <?php echo e($result["jenis_product"]); ?></h6>
              <input type="hidden" class="weight-product" value="<?php echo e($result["berat_product"]); ?>">
              <h6>Berat : <?php echo e($result["berat_product"]); ?> g</h6>
              <h6>Stock : <?php echo e($result["stock_product"]); ?> </h6>
              <input type="hidden"  class="stock_id" value="<?php echo e($result["stock_product"]); ?>">
            </div>
            <div class="row float-right">
              <div class="col-md">
                <input type="hidden" value="<?php echo e($result["id"]); ?>" id="product">
                  <?php if(Auth::check()): ?>
                    <button type="button" class="btn btn-warning btn-rounded float-right btn-masukan-keranjang">+Masukan Keranjang</button>
                    <button type="button" class="btn btn-success btn-rounded float-right btn-beli-langsung">Beli Langsung</button>
                  <?php else: ?> 
                    <button type="button" class="btn btn-warning btn-rounded float-right disabled">+Masukan Keranjang</button>
                    <button type="button" class="btn btn-success btn-rounded float-right" data-toggle="modal" data-target="#exampleModal">Beli Langsung</button>
                  <?php endif; ?>

                  <!-- MODAL CHECKOUT -->
                  <div class="modal fade" data-backdrop="static" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">CHECKOUT</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-4 order-md-2 mb-4">

                              <ul class="list-group mb-3 card-cart">
                                <p class="text-warning">Stock Tersedia : <?php echo e($result["stock_product"]); ?></p>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                  <div>
                                    <h6 class="my-0"><?php echo e($result["nama_product"]); ?></h6>
                                    <small class="text-muted"><?php echo e(ucfirst($result["jenis_product"])); ?></small>
                                    <input class="quantity form-control ml-5 qty-cart-manual text-center" min="0" name="quantity" value="1" type="number">
                                    <input type="hidden" class="first_price" value="<?php echo e($result["harga_product"]); ?>">
                                  </div>
                                  <span class="text-muted"><?php echo e(number_format($result["harga_product"],0,',','.')); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                  <span>Harga</span>
                                  <strong class="manual-total"><?php echo e(number_format($result["harga_product"],0,',','.')); ?></strong>
                                </li>
                                    <div class="row mt-2 pl-3 pr-3">
                                      <input type="text" class="form-control" placeholder="Promo code">
                                    </div>
                                    <div class="row pl-3">
                                      <button type="submit" class="btn btn-sm btn-light">Redeem</button>
                                    </div>
                                    <button id="manual-payment" class="btn btn-warning border rounded manual-payment"><h4 class="text-dark font-weight-bold mt-1">KONFIRMASI</h4></button>
                              </ul>

                            </div>
                            <div class="col-md-8 order-md-1">
                              <h4 class="mb-3">Isi Datamu</h4>
                              <form class="needs-validation" novalidate>
                                <div class="row">
                                  <div class="col-md-6 mb-3">
                                    <label for="firstName">First name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                                  </div>
                                </div>
                                <div class="mb-3">
                                  <label for="notelp">Nomor Telepon Aktif<span class="text-muted text-danger"> (Wajib)</span></label>
                                  <input type="tel" class="form-control" id="notelp" placeholder="08xxxxxx" required>
                                </div>
                                <div class="mb-3">
                                  <label for="email">Email <span class="text-muted">(Opsional)</span></label>
                                  <input type="email" class="form-control" id="email" placeholder="you@example.com">
                                </div>
                                <hr class="mb-4">
                                <h4 class="mb-3">Alamat Pengiriman</h4>
                                <div class="mb-3">
                                  <label for="address">Address</label>
                                  <textarea type="text" class="form-control" id="address" placeholder="Jl.Kembang gula No rumah/RT/RW" required> </textarea>
                              
                                </div>
                        
                                <div class="row">
                                  <div class="col-md-5 mb-3">
                                    <label for="province">Provinsi</label>
                                    <select class="custom-select d-block w-100 province" id="province" required>
                                      <option value="">Choose...</option>
                                        <?php $__currentLoopData = $shipment['province']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <option value="<?php echo e($value->province_id); ?>"><?php echo e($value->province); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                  </div>

                                  <div class="col-md-4 mb-3">
                                    <label for="city">Kota</label>
                                    <select class="custom-select d-block w-100 city" id="city" required>
                                      <option disabled value="">Pilih Provinsi Dulu</option>
                                    </select>
                                  </div>

                                  <div class="col-md-3 mb-3">
                                    <label for="zip">Zip</label>
                                    <input type="text" class="form-control zip" id="zip" placeholder="" required>
                                  </div>

                                </div>
                                <div class="row">
                                  <div class="col-md-4 mb-3 kurir">
                                         <!-- Group of material radios - option 1 -->
                                         <div class="form-check">
                                          <input type="radio" class="form-check-input courier" disabled id="courier" name="radio" value="jne">
                                          <label class="form-check-label" for="courier">JNE</label>
                                        </div>
                                        <!-- Group of material radios - option 2 -->
                                        <div class="form-check">
                                          <input type="radio" class="form-check-input courier" disabled id="pos" name="radio" value="pos">
                                          <label class="form-check-label" for="pos">POS</label>
                                        </div>
                                        <!-- Group of material radios - option 3 -->
                                        <div class="form-check">
                                          <input type="radio" class="form-check-input courier" disabled id="tiki" name="radio" value="tiki">
                                          <label class="form-check-label" for="tiki">TIKI</label>
                                        </div>
                                  </div>

                                  <div class="col-md-8 mb-3 courier_service">
                                         <!-- Courier Service Append in HERE -->
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <h4 for="notes">Notes</h4><p class="text-muted">*Ada tambahan keterangan untuk admin?</p>
                                    <textarea class="form-control" name="notes" id="notes" cols="50" rows="3" placeholder="..."></textarea>
                                  </div>
                                </div>
                                  <hr class="mb-4">
                                <h4 class="mb-3">Pembayaran</h4>
                                <div class="d-block my-3">
                                  <div class="custom-control custom-radio">
                                    <input id="manual" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                                    <label class="custom-control-label" for="manual">Manual</label>
                                  </div>
                                  <div class="custom-control custom-radio disabled">
                                    <input id="otomatis" name="paymentMethod" type="radio" class="custom-control-input" required>
                                    <label class="custom-control-label" for="otomatis">Otomatis <span class="text-muted">(Masih Dalam perbaikan)</span></label>
                                  </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="row">
                                    <div class="card">
                                      <div class="card-body">
                                        <h4>Silahkan Transfer ke Rekening Bank Berikut: </h4>
                                        <p>BCA : A/N Aguswin 934893485454</p>  
                                        <p>BCA : A/N Aguswin 934893485454</p>  
                                        <p>BCA : A/N Aguswin 934893485454</p>  
                                        <p>BCA : A/N Aguswin 934893485454</p>  
                                      </div>  
                                      <div class="card-footer">
                                        <h3 class="text-danger">PERHATIAN!!!</h3>
                                        <p class="text-danger">Sertakan NOMOR TELEPON Di Referensi Ketika Transfer Manual, Pesanan tidak diproses jika tidak menyertakan NOMOR TELEPON</p>
                                      </div>
                                    </div> 
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <div class="row">
                              <p>Mau Checkout <p class="bg-success rounded-lg">Cepat Dan MUDAH?</p> Daftar disini <a href="" class="btn btn-sm btn-success mb-3">Register</a></p>
                              <div class="dropdown-divider"></div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                   <!-- END MODAL CHECKOUT -->


              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="card">
          <div class="card-body">
            <h5><?php echo e($result["keterangan_product"]); ?></h5>
          </div>
          <div class="card-footer mt-2">
            <p>Product Di Update <?php echo e($result["created_at"]); ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user.appUser', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Coding\PORTFOLIO\bunga\resources\views/Product/ProductDetail.blade.php ENDPATH**/ ?>
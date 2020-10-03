<?php $__env->startSection('title', 'Konfirmasi Pembayaran'); ?>
  <!-- Page Content -->

<?php $__env->startSection('content'); ?>
<div class="container" style="margin-top: 15px;">
<div class="row">
    <div class="col-md-6">
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
                    <input type="text" class="form-control" id="nomor_telephone" placeholder="Masukan Nomor Telepon">
                    <span class="text-danger mt-3">*Nomor Telepon Harus Sesuai dengan Nomor yang di input sewaktu Checkout</span>
                </div>
            </div>
            <button class="btn btn-payment-confirmation btn-lg btn-success" disabled>Upload</button>
        </div>
    </div>
    <div class="col-md-6 col-cari-order-manual">
        <div class="card" style="min-height: 200px">
            <div class="card-header">
                <h4>Cek Pesanan</h4>
            </div>
            <div class="row ml-2">
                <div class="col-md-6">
                    <label for="nomor-telepon">Nomor Telepon</label>
                    <input type="text" name="nomor_telephone" class="form-control nomor_telephone" placeholder="Masukan Nomor Telepon">
                    <span class="text-danger mt-3">*Nomor Telepon Harus Sesuai dengan Nomor yang di input sewaktu Checkout</span>
                </div>
            </div>
            <button class="btn btn-lg btn-warning btn-check-pesanan">Cari</button>
        </div>
    </div>

            <!-- Small modal -->
    <div class="modal fade bd-example-modal-sm" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Alasan:</span>
                        </div>
                        <textarea class="form-control alasan-batal-pesanan" aria-label="With textarea"></textarea>
                    </div>
                    <button class="btn btn-sm btn-warning btn-batalkan-pesanan">Batalkan</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.user.appUser', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Coding\Portfolio\bunga\resources\views/Payment/PaymentConfirmation.blade.php ENDPATH**/ ?>
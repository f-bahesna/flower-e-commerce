<?php $__env->startSection('title','Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-4 mt-4">
          <a href="<?php echo e(route('order')); ?>">
            <div class="card bg-success">
                <div class="card-body text-center">
                <i class="fas fa-3x fa-cart-arrow-down"></i>
                  <h4 class="card-text text-dark">Pesanan Baru</h4>
                </div>
            </div>
          </a>
        </div>
        <div class="col-md-4 mt-4">
          <a href="<?php echo e(route('get.products')); ?>">
            <div class="card bg-success" id="btn-product">
                <div class="card-body text-center">
                <i class="fas fa-dark fa-3x fa-align-justify"></i>
                  <h4 class="card-text text-dark">Produk</h4>
                </div>
            </div>
          </a>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card bg-success">
                <div class="card-body text-center">
                    <i class="fas fa-3x fa-user-plus"></i>
                  <h4 class="card-text">Pelanggan</h4>
                </div>
              </div>
        </div>
        
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.appAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Coding\Portfolio\bunga\resources\views/ADMIN/Dashboard/dashboard.blade.php ENDPATH**/ ?>
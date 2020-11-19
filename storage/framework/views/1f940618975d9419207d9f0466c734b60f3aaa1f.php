<?php $__env->startSection('title', 'Bunga Homepage'); ?>
  <!-- Page Content -->
<?php $__env->startSection('content'); ?>
<div class="container" style="margin-top: 15px;">
    <div class="row">

        <div class="col-lg-3">
          <h4 class="my-4 text-center categories-title">Kategori</h4>
          <div class="list-group my-4 categories-list">
            <?php $__currentLoopData = $jenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <input type="hidden" class="jenis_product" value="<?php echo e($value->jenis_product); ?>">
              <a href="#" class="list-group-item categories-list-a"><?php echo e(ucfirst($value->jenis_product)); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
  
  
        </div>
        <!-- /.col-lg-3 -->
  
        <div class="col-lg-9">
            <input class="form-control mt-4" id="tableSearch" type="text"
                placeholder="Cari Tanaman Sanseviera ...">
  
          <div class="row mt-3" id="row-product">
            <?php $__currentLoopData = $products["data"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-6 mb-4 .jenis">
              <div class="card h-100">
                <a href="<?php echo e(route('product.detail',["id" => $product["id"]])); ?>"><img class="card-img-top" src="<?php echo e(url('storage/image/'.$product["gambar_product"])); ?>" style="height: 200px" alt=""></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href="<?php echo e(route('product.detail',["id" => $product["id"]])); ?>"><?php echo e($product["nama_product"]); ?></a>
                  </h4>
                  <h6><?php echo e("Rp " . number_format($product["harga_product"],2,',','.')); ?></h6>
                </div>
                <div class="card-footer">
                  <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
    </div>
    </div>
    <?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user.appUser', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Coding\PORTFOLIO\bunga\resources\views/Product/product.blade.php ENDPATH**/ ?>
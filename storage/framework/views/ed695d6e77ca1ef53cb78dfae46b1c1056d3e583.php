<?php $__env->startSection('title','KERANJANG KAMU'); ?>

<?php $__env->startSection('content'); ?>
<div class="row row-cart mt-2 mb-3">
    <div class="col-lg-8">
        <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <input type="hidden" class="id_product" value="<?php echo e($value->id_product); ?>">
        <div class="row bg-light p-1 rounded mb-3 border">
            <div class="col-md-2">
                <img height="100" width="100" class="img-thumbnail img-cart-details" src="<?php echo e(url('storage/image/'.$value->gambar_product)); ?>" alt="">
            </div>
            <div class="navbar-text col-md-3 mt-4 title-cart-details">
                <?php if(strlen($value->nama_product) > 15): ?>
                    <h5><?php echo e(substr($value->nama_product, 0, 14) . '...'); ?></h5>
                <?php else: ?>
                    <h5><?php echo e($value->nama_product); ?></h5>
                <?php endif; ?>
            </div>
            <div class="navbar-text col-md-2 mt-4 jenis-cart-details">
                <h5>Bunga</h5>
            </div>
            <div class="col-md-2 mt-4 qty-cart-details">
                <div class="row">
                    
                        <input class="quantity form-control ml-5 qty-cart text-center" min="0" name="quantity" value="<?php echo e($value->total); ?>" type="number">
                    
                </div>
            </div>
                <div class="col-md-2 mt-4 navbar-text total-cart-details"><h5>RP.<?php echo e(number_format($total[$key],0,',','.')); ?></h5></div>
                <div class="col-md-1 mt-4 navbar-text">
                    <i class="far float-right mt-2 trash-cart-details fa-1x fa-trash-alt"></i>
                </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
        <div class="col-lg-4 pembayaran-section">
            <div class="card">
                <div class="card-header">
                    <h4>Rincian</h4>
                </div>
                <div class="card-body">
                    <h5>Voucher : <h4>-</h4></h5>
                    <h5>Discount: <h4>20%</h4></h5>
                    <h5>Subtotal: <h3 class="text-success subTotal">RP <?php echo e(number_format($subTotal,0,',','.')); ?></h3><span><i class="fas fa-shipping-fast"></i> Free Ongkir</span></h5>
                    <div class="dropdown-divider"></div>
                </div>
                <div class="p-1 mt-2 bg-warning btn-pembayaran">
                    <h2 class="text-center btn-pembayaran-child font-weight-bold p-3">PEMBAYARAN</h2>
                </div>
            </div>
        </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-body">

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.user.appCart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Coding\PORTFOLIO\bunga\resources\views/cart/cart-details.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title','Product'); ?>
<?php $__env->startSection('content'); ?>
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
      <?php if($dataProducts): ?>
      <?php ($i = 1); ?>
        <?php $__currentLoopData = $dataProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <input type="hidden" class="product-id" value="<?php echo e($item->id); ?>">
            <td><?php echo e($i++); ?></td>
            <td><?php echo e($item->nama_product); ?></td>
            <td>
              <img src="<?php echo e(url('storage/image/'.$item->gambar_product)); ?>" height="200" width="200" alt="">
            </td>
            <td><?php echo e($item->jenis_product); ?></td>
            <td><?php echo e($item->umur_product); ?> Bln</td>
            <td><?php echo e($item->berat_product); ?>g</td>
            <td><?php echo e($item->stock_product); ?></td>
            <td><?php echo e($item->keterangan_product); ?></td>
            <td> 
            <?php if($item->status_product == 'published'): ?>
              <button type="button" class="btn btn-success btn-change btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo e(ucfirst($item->status_product)); ?>

              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item change-publish" status="draft" href="#">Drafted</a>
                <a class="dropdown-item change-publish" status="publish" href="#">Publish</a>
              </div>
            <?php else: ?>
            <button type="button" class="btn btn-warning btn-change btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo e(ucfirst($item->status_product)); ?>

            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item change-publish" status="publish" href="#">Publish</a>
              <a class="dropdown-item change-publish" status="draft" href="#">Drafted</a>
            </div>
            <?php endif; ?>
            </td>
            <td><?php echo e($item->created_at); ?></td>
            <td><?php echo e($item->created_by); ?></td>
            <td> 
              <a href="<?php echo e(route('get.detail.product',["id"=> $item->id])); ?>"><button class="btn btn-warning btn-sm"><i class="fas fa-2x fa-edit"></i></button></a>
              <input type="hidden" value="<?php echo e($item->id); ?>">
              <a href="#"><button class="btn mt-2 btn-danger btn-delete-product btn-sm"><i class="fas fa-2x fa-trash"></i></button></a>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    <?php else: ?>
    <tr>
      <td>Data Kosong</td>
    </tr>
    <?php endif; ?>
  </table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.appAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Coding\Portfolio\bunga\resources\views/ADMIN/Product/product.blade.php ENDPATH**/ ?>
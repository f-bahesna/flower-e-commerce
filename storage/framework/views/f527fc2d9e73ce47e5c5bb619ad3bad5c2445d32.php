<?php $__env->startSection('content'); ?>
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
            <tbody class="manual">
              <?php if($orders_manual): ?>
              <?php ($i = 1); ?>
                <?php $__currentLoopData = $orders_manual; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                    <input type="hidden" class="apn-order-code" value="<?php echo e($item->order_code); ?>">
                    <input type="hidden" class="apn-address" value="<?php echo e($item->address); ?>">
                    <input type="hidden" class="apn-province" value="<?php echo e($item->province); ?>">
                    <input type="hidden" class="apn-courier" value="<?php echo e($item->courier); ?>">
                    <input type="hidden" class="apn-courier-service" value="<?php echo e($item->courier_service); ?>">
                    <input type="hidden" class="apn-courier-price" value="<?php echo e($item->courier_price); ?>">
                    <input type="hidden" class="apn-total-price" value="<?php echo e($item->total_price); ?>">
                    <input type="hidden" class="apn-notes" value="<?php echo e($item->notes); ?>">
                    <input type="hidden" class="apn-status" value="<?php echo e($item->status); ?>">
                    
                    <input type="hidden" class="apn-nama-product" value="<?php echo e($item->nama_product); ?>">
                    <input type="hidden" class="apn-jenis-product" value="<?php echo e($item->jenis_product); ?>">
                    <input type="hidden" class="apn-harga-product" value="<?php echo e($item->harga_product); ?>">
                    <input type="hidden" class="apn-berat-product" value="<?php echo e($item->berat_product); ?>">
                    <input type="hidden" class="apn-payment-confirmation-image" src="<?php echo e(asset('storage/paymentConfirmation/'. $item->image)); ?>">

                    <input type="hidden" class="order_id" value="<?php echo e($item->id_order); ?>">
                    <td><?php echo e($i++); ?></td>
                    <td class="apn-nomor-telephone"><?php echo e($item->nomor_telephone); ?></td>
                    <?php switch($item->status):
                      case ('waiting'): ?>
                    <td><h6><span class="badge badge-warning"><?php echo e($item->status); ?></span></h6></td>
                      <?php break; ?>
                      <?php case ('cancel_process'): ?>
                    <td><h6><span class="badge badge-danger"><?php echo e($item->status); ?></span></h6></td>
                      <?php break; ?>
                      <?php case ('packing'): ?>
                    <td><h6><span class="badge badge-info"><?php echo e($item->status); ?></span></h6></td>
                      <?php break; ?>
                      <?php case ('shipping'): ?>
                    <td><h6><span class="badge badge-info"><?php echo e($item->status); ?></span></h6></td>
                      <?php break; ?>
                      <?php case ('done'): ?>
                    <td><h6><span class="badge badge-success"><?php echo e($item->status); ?></span></h6></td>
                      <?php break; ?>
                      <?php default: ?>
                    <td><h6><span class="badge"><?php echo e($item->status); ?></span></h6></td>
                      <?php endswitch; ?>
                    <td class="apn-city"><?php echo e($item->city); ?></td>
                    <td class="apn-nama-product"><?php echo e($item->nama_product); ?></td>
                    <td class="apn-qty"><?php echo e($item->qty); ?></td>
                  </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <?php else: ?>
            <tr>
              <td>Data Kosong</td>
            </tr>
            <?php endif; ?>
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
                              
                            </div>
                          </div>
                          <div class="row row-tolak">
                            <textarea class="form-control mt-2" id="textarea-tolak" placeholder="Tulis Alasan Penolakan" name="" id="" cols="30" rows="4"></textarea>
                            <button class="btn btn-sm btn-warning btn-cancel-tolak float-right mt-2 mr-2">cancel</button>
                              <input type="hidden" class="for-order-code-tolak" value="">
                            <button class="btn btn-sm btn-danger btn-confirm-tolak float-right mt-2">Confirm Tolak</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      
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
                    <input type="hidden" class="modal-order-code" value="">
                  <button type="button" class="btn btn-success btn-packing">Packing</button>
                    <input type="hidden" class="for-order-status" value="">
                </div>
              </div>
            </div>
          </div>

    </div>
    <div class="col-md-6">
      <h2>Order Otomatis</h2>
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
            <tbody class="otomatis">
              
              
                
                  <tr>
                    <input type="hidden" class="order_id" value="">
                    <td>1</td>
                    <td class="apn-nomor-telephone">0837466476</td>
                    
                    <td><h6><span class="badge badge-success">Packing</span></h6></td>
                      
                    <td class="apn-city">Tangerang</td>
                    <td class="apn-nama-product">Sanseviera</td>
                    <td class="apn-qty">4</td>
                  </tr>
                
            </tbody>
            
            
          </table>
        </div>
      </div>

    </div>
  </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.appAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Coding\Portfolio\bunga\resources\views/ADMIN/Order/OrderAdmin.blade.php ENDPATH**/ ?>
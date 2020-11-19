<?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-lg-6">
                <form id="form-send-message-manual">
                    <label for="">
                        <h4>Pesan Direct Manual</h4>
                    </label>
                    <div class="form-group">
                        <input type="number" class="form-control direct-nomor" name="nomor" id="nomor" placeholder="Masukkan Nomor Tujuan">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control direct-nomor" name="message" id="message" cols="30" rows="10" placeholder="Masukan Pesan"></textarea>
                    </div>
                    <button class="btn btn-sm btn-success float-right btn-direct-manual">Kirim</button>
                </form>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.appAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Coding\PORTFOLIO\bunga\resources\views/ADMIN/settings/message.blade.php ENDPATH**/ ?>
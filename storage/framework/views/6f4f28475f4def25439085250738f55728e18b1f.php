<?php $__env->startSection('title','Halaman Masuk'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <!-- Material form login -->
            <div class="card card-login d-flex">

                <h5 class="card-header bg-info white-text text-center py-4">
                <strong><?php echo e(__('Login')); ?></strong>
                </h5>
            
                <!--Card content-->
                <div class="card-body px-lg-5 pt-0 mt-5">
            
                <!-- Form -->
                <form class="text-center" style="color: #757575;" method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
            
                    <!-- Email -->
                    <div class="md-form mt-3">
                        <input placeholder="email" id="email" type="email" class="form-control <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>

                        <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
            
                    <!-- Password -->
                    <div class="md-form mt-3">
                        <input placeholder="password" id="password" type="password" class="form-control <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="password" required autocomplete="current-password">

                        <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
            
                    <div class="d-flex justify-content-around mt-3">
                    <div>
                        <!-- Remember me -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>

                            <label class="form-check-label" for="remember">
                                <?php echo e(__('Remember Me')); ?>

                            </label>
                        </div>
                    </div>


                    <div>
                        <!-- Forgot password -->
                        <a href="">Forgot password?</a>
                    </div>
                    </div>
            
                    <!-- Sign in button -->
                    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" id="btn-login" type="submit"> <?php echo e(__('Login')); ?></button>
            
                    <!-- Register -->
                    <p>Not a member?
                    <a href="<?php echo e(route('register')); ?>">Register</a>
                    </p>
            
                    <!-- Social login -->
                    <p>or sign in with:</p>
                    <a type="button" class="btn-floating btn-fb btn-sm">
                    <i class="fab fa-facebook-f"></i>
                    </a>
                    <a type="button" class="btn-floating btn-tw btn-sm">
                    <i class="fab fa-twitter"></i>
                    </a>
                    <a type="button" class="btn-floating btn-li btn-sm">
                    <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a type="button" class="btn-floating btn-git btn-sm">
                    <i class="fab fa-github"></i>
                    </a>
            
                </form>
                <!-- Form -->
            
                </div>
            
            </div>
            <!-- Material form login -->


        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user.appUser', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\Coding\Portfolio\bunga\resources\views/auth/login.blade.php ENDPATH**/ ?>
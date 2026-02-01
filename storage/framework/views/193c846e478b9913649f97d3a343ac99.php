
<?php $__env->startSection('title',__('Sign in to your account')); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="h4 text-body-emphasis mb-4"><?php echo e(__('Sign in to your account')); ?></h1>

    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="form"
          data-form-need-prevents-form-abandonment-value="false"
          data-action="form#submit"
          action="<?php echo e(route('platform.login.auth')); ?>">
        <?php echo csrf_field(); ?>

        <?php echo $__env->renderWhen($isLockUser,'platform::auth.lockme', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
        <?php echo $__env->renderWhen(!$isLockUser,'platform::auth.signin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('platform::auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\oblik\Desktop\P.A\vendor\orchid\platform\resources\views/auth/login.blade.php ENDPATH**/ ?>
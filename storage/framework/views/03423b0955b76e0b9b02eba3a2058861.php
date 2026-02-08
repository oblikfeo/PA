<form method="POST" action="<?php echo e($url); ?>" class="d-inline">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="is_enabled" value="<?php echo e($model->is_enabled ? '0' : '1'); ?>">
    <div class="form-check form-switch mb-0">
        <input class="form-check-input" type="checkbox" role="switch"
               <?php echo e($model->is_enabled ? 'checked' : ''); ?>

               onchange="this.form.querySelector('input[name=is_enabled]').value = this.checked ? '1' : '0'; this.form.submit();">
    </div>
</form>
<?php /**PATH C:\Users\oblik\Desktop\P.A\resources\views/platform/partials/schedule-enabled-switch.blade.php ENDPATH**/ ?>
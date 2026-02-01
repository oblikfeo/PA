<fieldset class="mb-3">

    <?php if(empty(!$title)): ?>
        <div class="col p-0 px-3">
            <legend class="text-body-emphasis mt-2 mx-2">
                <?php echo e($title); ?>

            </legend>
        </div>
    <?php endif; ?>

    <dl class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
        <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="d2-grid py-3 <?php echo e($loop->first ? '' : 'border-top'); ?>">
                <dt class="text-muted fw-normal me-3">
                    <?php echo $column->buildDt($repository); ?>

                </dt>
                <dd class="text-body-emphasis">
                    <?php echo $column->buildDd($repository); ?>

                </dd>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </dl>
</fieldset>
<?php /**PATH C:\Users\oblik\Desktop\P.A\vendor\orchid\platform\resources\views/layouts/legend.blade.php ENDPATH**/ ?>
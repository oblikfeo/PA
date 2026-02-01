<?php $__env->startComponent($typeForm, get_defined_vars()); ?>
    <div data-controller="relation"
         data-relation-id="<?php echo e($id); ?>"
         data-relation-placeholder="<?php echo e($attributes['placeholder'] ?? ''); ?>"
         data-relation-model="<?php echo e($relationModel); ?>"
         data-relation-name="<?php echo e($relationName); ?>"
         data-relation-key="<?php echo e($relationKey); ?>"
         data-relation-scope="<?php echo e($relationScope); ?>"
         data-relation-search-columns="<?php echo e($relationSearchColumns); ?>"
         data-relation-append="<?php echo e($relationAppend); ?>"
         data-relation-chunk="<?php echo e($chunk); ?>"
         data-relation-allow-empty="<?php echo e($allowEmpty); ?>"
         data-relation-route="<?php echo e(route('platform.systems.relation')); ?>"
         data-relation-message-notfound="<?php echo e(__('No results found')); ?>"
         data-relation-message-add="<?php echo e(__('Add')); ?>"
         data-relation-allow-add="<?php echo e(var_export($allowAdd, true)); ?>"
    >
        <select id="<?php echo e($id); ?>" data-relation-target="select" <?php echo e($attributes); ?>>
            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option selected value="<?php echo e($option['id']); ?>"><?php echo e($option['text']); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\oblik\Desktop\P.A\vendor\orchid\platform\resources\views/fields/relation.blade.php ENDPATH**/ ?>
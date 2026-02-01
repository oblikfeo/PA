<?php if (isset($component)) { $__componentOriginala871b0937f833a73f8d6540e05f15b48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala871b0937f833a73f8d6540e05f15b48 = $attributes; } ?>
<?php $component = Orchid\Platform\Components\Stream::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('orchid-stream'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Orchid\Platform\Components\Stream::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['target' => 'screen-state']); ?>
    <input type="hidden" name="_state" id="screen-state" value="<?php echo e($state); ?>">
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala871b0937f833a73f8d6540e05f15b48)): ?>
<?php $attributes = $__attributesOriginala871b0937f833a73f8d6540e05f15b48; ?>
<?php unset($__attributesOriginala871b0937f833a73f8d6540e05f15b48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala871b0937f833a73f8d6540e05f15b48)): ?>
<?php $component = $__componentOriginala871b0937f833a73f8d6540e05f15b48; ?>
<?php unset($__componentOriginala871b0937f833a73f8d6540e05f15b48); ?>
<?php endif; ?>
<?php /**PATH C:\Users\oblik\Desktop\P.A\vendor\orchid\platform\resources\views/partials/state.blade.php ENDPATH**/ ?>
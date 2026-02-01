<?php echo e($title); ?>


<?php if (isset($component)) { $__componentOriginal1d1976506f33d5d23fa37b3ec2628c63 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1d1976506f33d5d23fa37b3ec2628c63 = $attributes; } ?>
<?php $component = Orchid\Screen\Components\Popover::resolve(['content' => $popover] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('orchid-popover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Orchid\Screen\Components\Popover::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1d1976506f33d5d23fa37b3ec2628c63)): ?>
<?php $attributes = $__attributesOriginal1d1976506f33d5d23fa37b3ec2628c63; ?>
<?php unset($__attributesOriginal1d1976506f33d5d23fa37b3ec2628c63); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1d1976506f33d5d23fa37b3ec2628c63)): ?>
<?php $component = $__componentOriginal1d1976506f33d5d23fa37b3ec2628c63; ?>
<?php unset($__componentOriginal1d1976506f33d5d23fa37b3ec2628c63); ?>
<?php endif; ?>


<?php /**PATH C:\Users\oblik\Desktop\P.A\vendor\orchid\platform\resources\views/partials/layouts/dt.blade.php ENDPATH**/ ?>
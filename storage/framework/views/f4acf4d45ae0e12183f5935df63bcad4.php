<div class="mb-3 d-flex align-items-center">
    <div class="thumb-sm avatar me-3">
        <img src="<?php echo e($lockUser->presenter()->image()); ?>" class="b bg-light" alt="<?php echo e($lockUser->presenter()->title()); ?>">
    </div>
    <div class="d-flex flex-column overflow-hidden small">
        <span class="text-ellipsis"><?php echo e($lockUser->presenter()->title()); ?></span>
        <span class="text-muted d-block text-ellipsis"><?php echo e($lockUser->presenter()->subTitle()); ?></span>
    </div>
    <input type="hidden" name="email" required value="<?php echo e($lockUser->email); ?>">
</div>

<div class="mb-3">
    <input type="hidden" name="remember" value="true">

    <?php echo \Orchid\Screen\Fields\Password::make('password')
            ->required()
            ->autocomplete('current-password')
            ->tabindex(1)
            ->autofocus()
            ->placeholder(__('Enter your password')); ?>


    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="d-block invalid-feedback">
            <?php echo e($errors->first('email')); ?>

        </span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<div class="row align-items-center">
    <div class="col-md-6 col-xs-12">
        <a href="<?php echo e(route('platform.login.lock')); ?>" class="small">
            <?php echo e(__('Sign in with another user.')); ?>

        </a>
    </div>
    <div class="col-md-6 col-xs-12">
        <button id="button-login" type="submit" class="btn btn-default btn-block" tabindex="2">
            <?php if (isset($component)) { $__componentOriginal385240e1db507cd70f0facab99c4d015 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal385240e1db507cd70f0facab99c4d015 = $attributes; } ?>
<?php $component = Orchid\Icons\IconComponent::resolve(['path' => 'bs.box-arrow-in-right','class' => 'small me-2'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('orchid-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Orchid\Icons\IconComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal385240e1db507cd70f0facab99c4d015)): ?>
<?php $attributes = $__attributesOriginal385240e1db507cd70f0facab99c4d015; ?>
<?php unset($__attributesOriginal385240e1db507cd70f0facab99c4d015); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal385240e1db507cd70f0facab99c4d015)): ?>
<?php $component = $__componentOriginal385240e1db507cd70f0facab99c4d015; ?>
<?php unset($__componentOriginal385240e1db507cd70f0facab99c4d015); ?>
<?php endif; ?>
            <?php echo e(__('Login')); ?>

        </button>
    </div>
</div>
<?php /**PATH C:\Users\oblik\Desktop\P.A\vendor\orchid\platform\resources\views/auth/lockme.blade.php ENDPATH**/ ?>
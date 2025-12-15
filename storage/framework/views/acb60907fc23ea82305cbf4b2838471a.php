<!-- parameter yg diterima -->
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'disabled' => false,
    'errors'   => null,
    'label'    => false,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'disabled' => false,
    'errors'   => null,
    'label'    => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<!-- jenis class nya ketika error -->
<?php
    $errorClasses   = 'border-red-600 focus:border-red-600 ring-1 ring-red-600 focus:ring-red-600';
    $successClasses = 'border-emerald-500 focus:border-emerald-500 ring-1 ring-emerald-500 focus:ring-emerald-500';
    $defaultClasses = '';
?>

<!-- jika tag ada labelnya -->
<?php if($label): ?>
    <label <?php echo e($attributes->whereStartsWith('for')); ?>><?php echo e($label); ?></label>
<?php endif; ?>

<!-- settingan class input -->
 <!-- setting disabled or not -->
<input
    <?php echo e($disabled ? 'disabled' : ''); ?>

    <?php echo $attributes->merge([
        'class' =>
            'border-gray-300 focus:border-purple-500 focus:outline-none focus:ring-purple-500 rounded-md w-full ' .
            ($errors && $errors->has($attributes['name'])
                ? $errorClasses
                : (old($attributes['name']) ? $successClasses : $defaultClasses)),
    ]); ?>

/>

<?php $__errorArgs = [$attributes['name']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <small class="text-red-600"><?php echo e($message); ?></small>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
<?php /**PATH C:\Users\62812\Documents\LARAVEL FUNDAMENTAL\laravel vue ecommerce\ecommerce\resources\views/components/input.blade.php ENDPATH**/ ?>
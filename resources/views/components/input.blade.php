<!-- parameter yg diterima -->
@props([
    'disabled' => false,
    'errors'   => null,
    'label'    => false,
])

<!-- jenis class nya ketika error -->
@php
    $errorClasses   = 'border-red-600 focus:border-red-600 ring-1 ring-red-600 focus:ring-red-600';
    $successClasses = 'border-emerald-500 focus:border-emerald-500 ring-1 ring-emerald-500 focus:ring-emerald-500';
    $defaultClasses = '';
@endphp

<!-- jika tag ada labelnya -->
@if ($label)
    <label {{ $attributes->whereStartsWith('for') }}>{{ $label }}</label>
@endif

<!-- settingan class input -->
 <!-- setting disabled or not -->
<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' =>
            'border-gray-300 focus:border-purple-500 focus:outline-none focus:ring-purple-500 rounded-md w-full ' .
            ($errors && $errors->has($attributes['name'])
                ? $errorClasses
                : (old($attributes['name']) ? $successClasses : $defaultClasses)),
    ]) !!}
/>

@error($attributes['name'])
    <small class="text-red-600">{{ $message }}</small>
@enderror

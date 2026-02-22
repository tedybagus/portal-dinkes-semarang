@props([
    'label' => null,
])

<div class="space-y-1">
    @if ($label)
        <label class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    <input
        {{ $attributes->merge([
            'class' =>
                'w-full rounded-xl border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500'
        ]) }}
    >
</div>

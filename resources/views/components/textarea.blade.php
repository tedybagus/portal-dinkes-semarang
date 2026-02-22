@props([
    'label' => null,
    'name',
    'rows' => 4,
    'placeholder' => '',
    'hint' => null,
])

<div class="space-y-1">
    {{-- Label --}}
    @if($label)
        <label for="{{ $name }}"
               class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    {{-- Textarea --}}
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' =>
                'w-full rounded-lg border-gray-300 text-sm
                 focus:border-indigo-500 focus:ring-indigo-500
                 disabled:bg-gray-100 disabled:text-gray-500'
        ]) }}
    >{{ old($name, $slot) }}</textarea>

    {{-- Hint --}}
    @if($hint)
        <p class="text-xs text-gray-500">
            {{ $hint }}
        </p>
    @endif

    {{-- Error --}}
    @error($name)
        <p class="text-xs text-red-600">
            {{ $message }}
        </p>
    @enderror
</div>

<div>
    <label class="block text-sm text-gray-600 mb-1">{{ $label }}</label>
    <select name="{{ $name }}"
        class="w-full rounded-lg border-gray-300 focus:ring-indigo-500">
        @foreach($options as $key => $val)
            <option value="{{ $key }}"
                @selected($key == $selected)>
                {{ $val }}
            </option>
        @endforeach
    </select>
</div>

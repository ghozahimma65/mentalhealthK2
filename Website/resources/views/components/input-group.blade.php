<div class="space-y-1">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-400 {{ $class }}"
    />
    @error($name)
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>

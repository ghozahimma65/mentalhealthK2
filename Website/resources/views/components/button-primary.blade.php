<button type="submit" {{ $attributes->merge(['class' => 'px-4 py-2 font-bold text-white bg-purple-600 rounded hover:bg-purple-700']) }}>
    {{ $slot }}
</button>

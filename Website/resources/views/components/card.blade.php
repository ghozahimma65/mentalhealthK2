<div {{ $attributes->merge(['class' => 'p-6 bg-white border rounded-lg shadow']) }}>
    <div class="mb-4">
        <h2 class="text-xl font-bold text-purple-700">{{ $title }}</h2>
        <p class="text-sm text-gray-500">{{ $description }}</p>
    </div>
    {{ $slot }}
</div>

<div class="bg-white shadow-md rounded-lg p-6 {{ $styles ?? '' }}">
    <div style="display: flex; justify-content: space-between;">
        <h1 class="text-2xl font-bold mb-6">{{ $title ?? '' }}</h1>
        <div>{{ $side ?? '' }}</div>
    </div>
    {{ $slot }}
</div>

<span {{ $attributes->merge(['class' => 'text-purple-600 font-bold relative inline-block stroke-current']) }}>
    {{ $slot }}
    <x-icon-accent class="absolute bottom-0 w-full max-h-1.5" />
</span>
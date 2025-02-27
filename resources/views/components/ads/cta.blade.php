@props(['primary' => false])

<p {{ $attributes->merge(['class' => 'text-center px-4']) }}>
    <a href="https://github.com/sponsors/laravelio" target="_blank" rel="noopener"
       class="text-base border-b pb-1 {{ isset($primary) && $primary ? 'text-purple-600 border-purple-100 hover:text-purple-700' : 'text-gray-700 border-gray-300 hover:text-gray-500' }}">
        {{ $slot }}
    </a>
</p>
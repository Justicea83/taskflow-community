<span class="inline-flex rounded shadow-sm {{ $attributes->get('class') }}">
    @if ($attributes->has('href'))
        <a {{ $attributes->except('class') }} class="w-full bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 border border-transparent rounded py-2 px-4 inline-flex justify-center text-lg leading-6 text-white">
            {{ $slot }}
        </a>
    @else
        <button {{ $attributes->except('class') }} class="w-full bg-purple-600 hover:bg-purple-700 focus:bg-purple-700 border border-transparent rounded py-2 px-4 inline-flex justify-center text-lg leading-6 text-white">
            {{ $slot }}
        </button>
    @endif
</span>
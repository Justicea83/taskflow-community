<span class="inline-flex rounded shadow-sm {{ $attributes->get('class') }}">
    @if ($attributes->has('href'))
        <a {{ $attributes->except('class') }} class="w-full bg-[#5B45E5] hover:bg-blue-700 focus:bg-blue-700 border border-transparent rounded py-2 px-4 inline-flex justify-center text-lg leading-6 text-white hover:bg-blue-700">
            {{ $slot }}
        </a>
    @else
        <button {{ $attributes->except('class') }} class="w-full bg-[#5B45E5] hover:bg-blue-700 focus:bg-blue-700 border border-transparent rounded py-2 px-4 inline-flex justify-center text-lg leading-6 text-white hover:bg-blue-700">
            {{ $slot }}
        </button>
    @endif
</span>
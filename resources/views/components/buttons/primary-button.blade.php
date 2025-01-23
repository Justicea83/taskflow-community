@props(['fullWidth' => false])

<span class="{{ $fullWidth ? 'flex' : 'inline-flex' }} rounded-md shadow-sm">
    @if ($attributes->has('href'))
        <a {{ $attributes->merge(['class' => ($fullWidth ? 'w-full ' : '') . 'bg-purple-600  border border-transparent rounded py-2 px-4 inline-flex justify-center text-base text-white hover:bg-purple-700 font-medium']) }}>
            {{ $slot }}
        </a>
    @else
        <button {{ $attributes->merge(['class' => ($fullWidth ? 'w-full ' : '') . 'bg-purple-600  border border-transparent rounded py-2 px-4 inline-flex justify-center text-base text-white hover:bg-purple-700 font-medium']) }}>
            {{ $slot }}
        </button>
    @endif
</span>
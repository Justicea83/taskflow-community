@props([
    'tag' => 'a',
    'selected' => false,
])

<{{ $tag }} {{ $attributes }} class="@if($selected) text-purple-600 @endif flex rounded-full p-3 transition duration-300 ease-in-out hover:text-purple-600 hover:bg-purple-700 hover:opacity-50">
    {{ $slot }}
</{{ $tag }}>
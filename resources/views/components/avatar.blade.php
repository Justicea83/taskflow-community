@props([
    'user',
    'unlinked' => false,
])

@unless ($unlinked)
    <a href="{{ route('profile', $user->username()) }}">
@endunless

@if ($user->githubUsername())
    <x-buk-avatar
        :search="$user->githubUsername()"
        provider="github"
        :fallback="asset('images/gray.png')"
        {{-- :alt="$user->name()" --}}
        {{ $attributes->merge(['class' => 'bg-gray-50 rounded-full']) }}
    />
@else
    <img loading="lazy"
        src="{{ asset('images/gray.png') }}"
        alt="{{ $user->name() }}"
        {{ $attributes->merge(['class' => 'bg-gray-50 rounded-full']) }}
    />
@endif

@unless ($unlinked)
    </a>
@endunless

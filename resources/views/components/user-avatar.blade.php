@props(['user', 'class' => ''])

<span {{ $attributes->merge(['class' => 'avatar '.$class]) }} aria-label="Foto profil {{ $user->name }}">
    @if ($user->profile_photo_url)
        <img src="{{ $user->profile_photo_url }}" alt="" loading="lazy" decoding="async" onerror="this.hidden=true;this.nextElementSibling.hidden=false">
        <span data-avatar-fallback hidden aria-hidden="true">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
    @else
        <span aria-hidden="true">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
    @endif
</span>

@props(['light' => false, 'tagline' => false])

@php($useLightLogo = $light || request()->routeIs('admin.*', 'karyawan.*', 'profile.*'))

<span {{ $attributes->merge(['class' => 'brand-logo'.($light ? ' brand-logo--light' : '')]) }}>
    <img src="{{ asset('images/'.($useLightLogo ? 'nok-wordmark-light.png' : 'nok-wordmark.png')) }}?v=3" alt="NOK" class="brand-logo__image">
    @if ($tagline)
        <span class="brand-logo__tagline">Sistem Kehadiran</span>
    @endif
</span>

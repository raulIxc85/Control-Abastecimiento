@php

$breadcrumbs = [
    'Dashboard' => route('dashboard'),
    'Pilotos' => false
];

@endphp

<x-admin-layout>
    <livewire:header title="Pilotos"/>
    <livewire:breadcrumbs :breadcrumb-items="$breadcrumbs" />

    <div class="py-1">
        <livewire:Pilots.list-pilot/>
    </div>
</x-admin-layout>



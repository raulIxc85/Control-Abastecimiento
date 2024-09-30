@php

$breadcrumbs = [
    'Dashboard' => route('dashboard'),
    'Agencias' => false
];

@endphp

<x-admin-layout>
    <livewire:header title="Agencias"/>
    <livewire:breadcrumbs :breadcrumb-items="$breadcrumbs"/>

    <div class="py-1">
        <livewire:Agencies.form-agency 
            :agencyId="$agencyId"
        />
    </div>
</x-admin-layout>

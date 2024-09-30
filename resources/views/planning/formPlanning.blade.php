@php

$breadcrumbs = [
    'Dashboard' => route('dashboard'),
    'Planificación' => false
];

@endphp

<x-admin-layout>
    <livewire:header title="Planificación"/>
    <livewire:breadcrumbs :breadcrumb-items="$breadcrumbs"/>

    <div class="py-1">
        <livewire:Planning.form-planning
            :applicationId="$applicationId"
        />
    </div>
</x-admin-layout>



@php

$breadcrumbs = [
    'Dashboard' => route('dashboard'),
    'Control de pedidos' => false
];

@endphp

<x-admin-layout>
    <livewire:header title="Control de pedidos"/>
    <livewire:breadcrumbs :breadcrumb-items="$breadcrumbs"/>

    <div class="py-1">
        <livewire:Orders.form-order
            :applicationId="$applicationId"
        />
    </div>
</x-admin-layout>

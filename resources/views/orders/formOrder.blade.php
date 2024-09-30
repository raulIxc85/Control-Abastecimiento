<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Control de pedidos') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <livewire:Orders.form-order
            :applicationId="$applicationId"
        />
    </div>
</x-admin-layout>

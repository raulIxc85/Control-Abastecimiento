<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planificacion') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <livewire:Planning.list-planning/>
    </div>
</x-admin-layout>



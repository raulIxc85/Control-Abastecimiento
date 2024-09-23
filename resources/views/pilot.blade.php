<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilotos') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <livewire:Pilots.pilots/>
    </div>
</x-admin-layout>



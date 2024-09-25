<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agencias') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <livewire:Agencies.form-agency 
            :agencyId="$agencyId"
        />
    </div>
</x-admin-layout>

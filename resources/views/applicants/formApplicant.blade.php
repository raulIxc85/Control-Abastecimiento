<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitantes') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <livewire:Applicants.form-applicant 
            :applicantId="$applicantId"
        />
    </div>
</x-admin-layout>



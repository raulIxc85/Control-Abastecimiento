<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Pilot;

new class extends Component {
    use WithPagination;
    
    public function with()
    {
        return [
            'pilots' => Pilot::paginate(10)
        ];
        
    }
}; ?>

<div class="bg-gray-100 py-10">
    <div class="mx-auto max-w-7xl">
        <div class="px-4 sm:px-6 lg:px-8">
            <!-- Mostrar mensaje de éxito -->
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Éxito!</strong>
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">
                        Pilotos
                    </h1>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a wire:navigate href=" {{ route('pilots.create') }}"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                        Agregar piloto
                    </a>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            Piloto
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6" />
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse($pilots as $pilot)
                                        <tr>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                {{ $pilot->name }}
                                            </td>
                                            <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a wire:navigate href="{{ route('pilots.edit', $pilot->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    Edit
                                                </a>
                                                <button wire:confirm="¿Esta seguro de borrar el piloto?"
                                                    wire:click=""
                                                    class="ml-2 text-indigo-600 hover:text-indigo-900">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="bg-white">
                                            <td colspan="3" class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                               No hay datos para mostrar
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5">
                            {{ $pilots->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
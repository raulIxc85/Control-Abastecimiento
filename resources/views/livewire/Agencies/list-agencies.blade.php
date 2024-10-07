<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Agency;

new class extends Component {
    use WithPagination;
    
    public function with()
    {
        return [
            'agencies' => Agency::where('status', true)
                            ->orderBy('name', 'asc') 
                            ->paginate(10)
        ];
    }

    public function delete($agencyId)
    {
        $agency = Agency::findOrFail($agencyId);
        $agency->status = false;
        $agency->save();

        session()->flash('message', 'Agencia eliminada exitosamente.');
    }
}; ?>

<div class="dark:bg-gray-600 py-5">
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
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a wire:navigate href=" {{ route('agencies.create') }}"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 sm:w-auto">
                        Crear agencia
                    </a>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 dark:text-gray-300">
                                            Codigo
                                        </th>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 dark:text-gray-300">
                                            Agencia
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6" />
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white dark:bg-gray-900">
                                    @forelse($agencies as $agency)
                                        <tr>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 dark:text-gray-300">
                                                {{ $agency->code_agency }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 dark:text-gray-300">
                                                {{ $agency->name }}
                                            </td>
                                            <td
                                                class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <button wire:navigate href="{{ route('agencies.edit', $agency->id) }}"
                                                    class="ml-2 text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                    <x-heroicon-s-pencil class="size-6" />
                                                </button>
                                                <button onclick="confirmDelete('{{ $agency->id }}')"
                                                    class="ml-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    <x-heroicon-s-trash class="size-6" />
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="bg-white dark:bg-gray-900">
                                            <td colspan="3" class="px-6 py-4 text-sm leading-5 text-gray-900 dark:text-gray-300 whitespace-no-wrap">
                                               No hay datos para mostrar
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5">
                            {{ $agencies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(pilotId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', pilotId);
                Swal.fire(
                    'Eliminado!',
                    'La agencia ha sido eliminada.',
                    'success'
                )
            }
        })
    }
</script>


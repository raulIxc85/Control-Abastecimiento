<?php

use Livewire\Volt\Component;
use App\Models\Pilot;

new class extends Component {
    public $form = [
        'name' => ''
    ];

    public $pilotId;

    public function mount($pilotId = null)
    {
        $this->pilotId = $pilotId;
        if ($this->pilotId) {
            $pilot = Pilot::findOrFail($this->pilotId->id);
            $this->form['name'] = $pilot->name;
        }
    }

    public function save()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:pilots,name',
        ], [
            'form.name.required' => 'Ingrese un nombre', 
            'form.name.unique' => 'El nombre del piloto ya existe. Por favor, elige otro nombre.',
        ]);

        $user = auth()->user();

        if ($this->pilotId) {
            $pilot = Pilot::findOrFail($this->pilotId->id);
            $pilot->update([
                'name' => $this->form['name'],
            ]);
            session()->flash('message', 'Piloto actualizado exitosamente.');
            return redirect()->route('pilots.index');
        } else {
            Pilot::create([
                'name' => $this->form['name'],
                'user_id' => $user->id
            ]);
     
            session()->flash('message', 'Piloto creado exitosamente.');
            return redirect()->route('pilots.index');
        }
    }
}; ?>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
            <form wire:submit.prevent="save">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="bg-white dark:bg-gray-800 py-6 px-4 space-y-6 sm:p-6">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">
                                {{ $pilotId ? 'Actualizar piloto' : 'Crear piloto' }}
                            </h3>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                <input type="text" id="name" wire:model="form.name"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 @error('form.name') text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300 @enderror
                                "/>
                                @error('form.name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800 text-left sm:px-6">
                        <a wire:navigate href="{{ route('pilots.index') }}" as="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-700">
                            Regresar
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ $pilotId ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

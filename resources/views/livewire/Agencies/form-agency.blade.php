<?php

use Livewire\Volt\Component;
use App\Models\Agency;

new class extends Component {
    public $form = [
        'code_agency' => '',
        'name' => ''
    ];

    public $agencyId;

    public function mount($agencyId = null)
    {
        $this->agencyId = $agencyId;
        if ($this->agencyId) {
            $agency = Agency::findOrFail($this->agencyId->id);
            $this->form['code_agency'] = $agency->code_agency;
            $this->form['name'] = $agency->name;
        }
    }

    public function save()
    {
        $rules = [
            'form.name' => 'required|string|max:50',
        ];
    
        if (!$this->agencyId) {
            $rules['form.code_agency'] = 'required|string|max:10|unique:agencies,code_agency';
        }
    
        $messages = [
            'form.code_agency.required' => 'Ingrese código de agencia', 
            'form.code_agency.unique' => 'El código de la agencia ya existe. Por favor, elige otro código.',
            'form.name.required' => 'Ingrese nombre de agencia', 
        ];
    
        $this->validate($rules, $messages);

        $user = auth()->user();

        if ($this->agencyId) {
            $agency = Agency::findOrFail($this->agencyId->id);
            $agency->update([
                'code_agency' => $this->form['code_agency'],
                'name' => $this->form['name']
            ]);
            session()->flash('message', 'Agencia actualizada exitosamente.');
            return redirect()->route('agencies.index');
        } else {
            Agency::create([
                'code_agency' => $this->form['code_agency'],
                'name' => $this->form['name'],
                'user_id' => $user->id
            ]);
     
            session()->flash('message', 'Agencia creada exitosamente.');
            return redirect()->route('agencies.index');
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
                                {{ $agencyId ? 'Actualizar agencia' : 'Crear agencia' }}
                            </h3>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="code_agency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Codigo</label>
                                <input type="text" id="code_agency" wire:model="form.code_agency"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200  @error('form.name') text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300  @enderror
                                "/>
                                @error('form.code_agency')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Agencia</label>
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
                        <a wire:navigate href="{{ route('agencies.index') }}" as="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-700">
                            Regresar
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ $agencyId ? 'Actualizar' : 'Guardar' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

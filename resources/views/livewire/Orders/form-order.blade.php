<?php

use Livewire\Volt\Component;
use App\Models\Application;
use App\Models\Agency;
use App\Models\User;

new class extends Component {
    public $form = [
        'date' => '',
        'pallet_quantity' => 0,
        'order' => '',
        'status' => 'Solicitado'
    ];

    public $applicationId;
    public $status = 'Solicitado';
    public $isEditing = false;
    public $statusForm = '';
    public $excelFile = '';
    public $agencies;


    public function mount($applicationId = null)
    {
        $this->applicationId = $applicationId;
        if ($this->applicationId) {
            $application = Application::findOrFail($this->applicationId->id);
            $this->form['date'] = $application->date;
            $this->form['pallet_quantity'] = $application->pallet_quantity;
            $this->form['order'] = $application->order;
            $this->form['pallet_requirement'] = $application->pallet_requirement;
            $this->form['origin_agency_id'] = $application->origin_agency_id;
            $this->form['destination_agency_id'] = $application->destination_agency_id;
            $this->form['status'] = $application->status;
            $this->excelFile = $application->excel_file;
            $this->statusForm = $application->status;
            if ($this->statusForm == 'Enviado'){
                $this->isEditing = true;
            }
            if ($this->statusForm == 'Finalizado'){
                $this->isEditing = true;
            }
            if ($this->statusForm == 'Requerido'){
                $this->isEditing = true;
            }
            if ($this->statusForm == 'Pedido'){
                $this->isEditing = true;
            }
            if ($this->statusForm == 'Confirmado'){
                $this->isEditing = true;
            }
        }
        $this->agencies = Agency::all();
    }

    public function save()
    {
        if($this->status == 'Solicitado'){
            $this->validate([
                'form.date' => 'required|date',
                'form.pallet_quantity' => 'required|integer|min:1',
                'form.origin_agency_id' => 'required',
                'form.destination_agency_id' => 'required',
            ], [
                'form.date.required' => 'Ingrese una fecha', 
                'form.pallet_quantity.required' => 'Ingrese cantidad de pallet',
                'form.origin_agency_id' => 'Seleccione origen',
                'form.destination_agency_id' => 'Seleccione destino',
            ]);
        }

        if($this->statusForm == 'Requerido'){
            $this->validate([
                'form.order' => 'required',
            ], [
                'form.order' => 'Debe de ingresar pedido',
            ]);
        }

        $user = auth()->user();

        if ($this->applicationId) {
            if($this->statusForm == 'Enviado'){
                $application = Application::findOrFail($this->applicationId->id);
                $application->update([
                    'status' => 'Confirmado',
                    'modified_user_id' => $user->id
                ]);
                session()->flash('message', 'Solicitud actualizado exitosamente.');
                return redirect()->route('orders.index');
            }else{
                if($this->statusForm == 'Solicitado'){
                    $application = Application::findOrFail($this->applicationId->id);
                    $application->update([
                        'pallet_quantity' => $this->form['pallet_quantity'],
                        'origin_agency_id' => $this->form['origin_agency_id'],
                        'destination_agency_id' => $this->form['destination_agency_id'],
                        'modified_user_id' => $user->id
                    ]);
                    session()->flash('message', 'Solicitud modificado exitosamente.');
                    return redirect()->route('orders.index');
                }else{
                    $application = Application::findOrFail($this->applicationId->id);
                    $application->update([
                        'order' => $this->form['order'],
                        'status' => 'Pedido',
                        'modified_user_id' => $user->id
                    ]);
                    session()->flash('message', 'Solicitud actualizado exitosamente.');
                    return redirect()->route('orders.index');
                }
            }
        } else {
            $existingRecord = Application::where('pallet_quantity', $this->form['pallet_quantity'])
                ->where('origin_agency_id', $this->form['origin_agency_id'])
                ->where('destination_agency_id', $this->form['destination_agency_id'])
                ->where('date', $this->form['date'])
                ->first();

            if ($existingRecord) {
                session()->flash('message', 'Ya existe una solicitud con la misma fecha, cantidad, origen y destino.');
            }else{
                Application::create([
                    'date' => $this->form['date'],
                    'pallet_quantity' => $this->form['pallet_quantity'],
                    'origin_agency_id' => $this->form['origin_agency_id'],
                    'destination_agency_id' => $this->form['destination_agency_id'],
                    'status' => $this->status,
                    'user_id' => $user->id
                ]);
         
                session()->flash('message', 'Solicitud creado exitosamente.');
    
                return redirect()->route('orders.index');
            }
        }
    }

    public function downloadFile($filePath)
    {
        return Storage::download($filePath);
    }

}; ?>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
            <form wire:submit.prevent="save">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <!-- Mostrar mensaje -->
                    @if (session()->has('message'))
                        <div class="mb-4 bg-red-200 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">¡Error!</strong>
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif
                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $applicationId ? 'Control de pedido - Actualizar pedido / Status:' : 'Crear solicitud' }} {{$statusForm}}
                                </h3>
                            </h3>
                        </div>
                        <div class="grid grid-cols-12 gap-12">
                            <div class="col-span-6 sm:col-span-6">
                                <label for="date" class="block text-sm font-medium text-gray-700">Fecha:</label>
                                <input type="date" id="date" wire:model="form.date"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('form.name') text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300 @enderror
                                " {{ $isEditing ? 'disabled' : '' }} />
                                @error('form.date')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-6">
                                <label for="pallet_quantity" class="block text-sm font-medium text-gray-700">Cantidad de pallet:</label>
                                <input type="number" id="pallet_quantity" wire:model="form.pallet_quantity"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('form.name') text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300 @enderror
                                " {{ $isEditing ? 'disabled' : '' }}/>
                                @error('form.pallet_quantity')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-12">
                            <div class="col-span-6 sm:col-span-6">
                                <label for="origin_agency_id" class="block text-sm font-medium text-gray-700">Origen:</label>
                                <select id="origin_agency_id" wire:model="form.origin_agency_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" {{ $isEditing ? 'disabled' : '' }}>
                                    <option value="">Seleccione origen</option>
                                        @foreach($agencies as $agency)
                                            <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                                        @endforeach
                                </select>
                                @error('form.origin_agency_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-6 sm:col-span-6">
                                <label for="destination_agency_id" class="block text-sm font-medium text-gray-700">Destino:</label>
                                <select id="destination_agency_id" wire:model="form.destination_agency_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" {{ $isEditing ? 'disabled' : '' }}>
                                    <option value="">Seleccione destino</option>
                                    @foreach($agencies as $agency)
                                        <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                                    @endforeach
                                </select>
                                @error('form.destination_agency_id')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @if($form['status'] !== 'Solicitado')
                            <div class="grid grid-cols-12 gap-12">
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="pallet_requirement" class="block text-sm font-medium text-gray-700">Requerimiento de pallet:</label>
                                    <input type="number" id="pallet_requirement" wire:model="form.pallet_requirement"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('form.name') text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300 @enderror
                                    " disabled />
                                    @error('form.pallet_requirement')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                @if($form['status'] == 'Requerido' || $form['status'] == 'Pedido')
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="order" class="block text-sm font-medium text-gray-700">Pedido:</label>
                                        <input type="text" id="order" wire:model="form.order"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('form.name') text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300 @enderror
                                        " />
                                        @error('form.order')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                                @if($form['status'] == 'Enviado' || $form['status'] == 'Finalizado' || $form['status'] == 'Confirmado')
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="order" class="block text-sm font-medium text-gray-700">Pedido:</label>
                                        <input type="text" id="order" wire:model="form.order"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('form.name') text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300 @enderror
                                        " disabled />
                                        @error('form.order')
                                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if($form['status'] == 'Enviado' || $form['status'] == 'Finalizado')
                            <div class="grid grid-cols-12 gap-12">
                                <div class="col-span-6 sm:col-span-6">
                                    <a 
                                        wire:click="downloadFile('{{ $excelFile }}')" 
                                        class="bg-black border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Descargar Excel
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-left sm:px-6">
                        <a wire:navigate href="{{ route('orders.index') }}" as="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Regresar
                        </a>
                        @if($form['status'] == 'Enviado')
                            <button type="submit"
                                class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Confirmar
                            </button>
                        @endif
                        @if($form['status'] == 'Solicitado' || $form['status'] == 'Pedido' || $form['status'] == 'Requerido')
                            <button type="submit"
                                class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ $applicationId ? 'Actualizar' : 'Guardar' }}
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadExcel extends Component
{
    use WithFileUploads;

    public $file;

    public function updatedFile()
    {
        $this->validate([
            'file' => 'required|file|mimes:xls,xlsx|max:5048', // Validación del archivo
        ], [
            'file.required' => 'Seleccione un archivo Excel antes de guardar',
            'file.mimes' => 'Solo se permiten archivos Excel (.xls, .xlsx)',
            'file.max' => 'El archivo no debe superar los 5 MB.',
        ]);
        $filePath = $this->file->store('uploads/excel_files');
        $this->dispatch('fileUploaded', $filePath);
    }

    public function render()
    {
        return view('livewire.upload-excel');
    }
}

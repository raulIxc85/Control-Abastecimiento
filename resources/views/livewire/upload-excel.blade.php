<div>
    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seleccionar archivo Excel:</label>
    <input type="file" id="file" wire:model="file" 
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 @error('file') text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300 @enderror" />

    @error('file')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
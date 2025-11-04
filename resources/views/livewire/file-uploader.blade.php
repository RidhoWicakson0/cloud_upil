<div>
    <button wire:click="openModal" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
        Upload Foto
    </button>

    @if ($showUploadModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        
        <div class="fixed inset-0 bg-black/70" wire:click="closeModal" wire:loading.disable></div>

        <div class="relative w-full max-w-lg bg-white rounded-lg shadow-xl dark:bg-gray-800">
            
            <button wire:click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="p-6 border-b dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Upload New Photo
                </h3>
            </div>

            <form wire:submit="save">
                <div class="p-6 space-y-4">
                    
                    <div>
                        @if ($photo && !$errors->has('photo'))
                            <div class="text-center">
                                <img src="{{ $photo->temporaryUrl() }}" class="max-h-64 mx-auto rounded-lg">
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $photo->getClientOriginalName() }}
                                </p>
                            </div>
                        @else
                            <label for="file-upload" class="relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-4-4V7a4 4 0 014-4h5l4 4h5a4 4 0 014 4v8a4 4 0 01-4 4H7z"></path></svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-semibold">Drag & drop</span> your photo here
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        or click to browse files
                                    </p>
                                </div>
                                <input id="file-upload" wire:model="photo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                            </label>
                        @endif
                    </div>

                    <div wire:loading wire:target="photo" class="text-sm text-gray-500 dark:text-gray-400">
                        Uploading...
                    </div>

                    @error('photo')
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4 p-6 bg-gray-50 dark:bg-gray-900 rounded-b-lg">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Upload
                    </button>
                </div>
            </form>

        </div>
    </div>
    @endif
</div>
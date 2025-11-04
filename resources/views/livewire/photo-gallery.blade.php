<div>
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
        Galeri Foto Saya
    </h3>

    <div class="mb-6">
        <button 
            wire:click="downloadAllAsZip" 
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
        >
            Unduh Semua (ZIP)
        </button>
        
        @if (session('zip_error'))
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ session('zip_error') }}</p>
        @endif
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse ($files as $file)
            <div class="relative group bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md border border-gray-200 dark:border-gray-700">
                <a href="{{ Storage::url($file->path) }}" target="_blank">
                    <img src="{{ Storage::url($file->path) }}" 
                         alt="{{ $file->file_name }}" 
                         class="w-full h-32 object-cover transition-transform duration-300 group-hover:scale-105">
                </a>
                
                <div class="p-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $file->file_name }}">
                        {{ $file->file_name }}
                    </p>
                    
                    <div class="mt-3 flex justify-between items-center">
                        <a href="{{ Storage::url($file->path) }}" 
                           download="{{ $file->file_name }}"
                           class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500"
                        >
                            Unduh
                        </a>
                
                        <button 
                            wire:click="delete({{ $file->id }})"
                            wire:confirm="Anda yakin ingin menghapus file {{ $file->file_name }}?"
                            class="text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-500"
                        >
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 dark:text-gray-400">Anda belum meng-upload file apapun.</p>
            </div>
        @endforelse
    </div>
</div>
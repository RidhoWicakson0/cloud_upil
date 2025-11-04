<div class="mt-6">
    <h4 class="font-semibold">Monitor Semua Foto User (Mode Blur)</h4>

    <style>
        .admin-blur {
            filter: blur(8px); /* Atur tingkat blur di sini */
            transition: filter 0.3s ease;
        }
        .admin-blur:hover {
            filter: blur(0px); /* Hilangkan blur saat di-hover */
        }
    </style>

    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;">
        @forelse ($files as $file)
            <div style="border: 1px solid #ccc; padding: 5px; text-align: center;">
                <img src="{{ Storage::url($file->path) }}" 
                     alt="{{ $file->file_name }}" 
                     width="150"
                     class="admin-blur"> 

                <small>Milik: {{ $file->user->name ?? 'User Dihapus' }}</small>
            </div>
        @empty
            <p>Belum ada file yang di-upload oleh user.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $files->links() }}
    </div>
</div>
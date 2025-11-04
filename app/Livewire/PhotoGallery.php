<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive; // <-- Pastikan ini ada

class PhotoGallery extends Component
{
    // Ini akan me-refresh komponen saat file baru di-upload
    protected $listeners = ['file-uploaded' => '$refresh'];

    /**
     * Fungsi untuk menghapus file individual.
     */
    public function delete($fileId)
    {
        // Cari file, tapi pastikan itu milik user yg login
        $file = File::where('id', $fileId)
                    ->where('user_id', auth()->id()) 
                    ->firstOrFail(); // Gagal jika org lain coba hapus

        // 1. Hapus file fisik dari storage
        Storage::disk('public')->delete($file->path);

        // 2. Hapus data dari database
        $file->delete();

        session()->flash('status', 'File berhasil dihapus.');
    }

    /**
     * Fungsi baru untuk men-download semua file sebagai ZIP.
     */
    public function downloadAllAsZip()
    {
        // 1. Ambil semua file milik user
        $files = File::where('user_id', auth()->id())->get();

        if ($files->isEmpty()) {
            // Tampilkan error jika tidak ada file
            session()->flash('zip_error', 'Anda tidak memiliki file untuk diunduh.');
            return;
        }

        // 2. Buat nama dan path unik untuk file zip
        $zipFileName = 'galeri_saya_' . auth()->id() . '_' . time() . '.zip';
        $zipFilePath = storage_path('app/temp/' . $zipFileName);

        // 3. Pastikan direktori temp ada (buat jika belum)
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        // 4. Buat file Zip
        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            session()->flash('zip_error', 'Gagal membuat file zip. (Cek dependensi php-zip)');
            return;
        }

        // 5. Tambahkan file-file ke dalam zip
        foreach ($files as $file) {
            // Pastikan file-nya ada di storage
            if (Storage::disk('public')->exists($file->path)) {
                // Ambil isi file
                $fileContent = Storage::disk('public')->get($file->path);
                
                // Tambahkan file ke zip menggunakan nama file aslinya
                $zip->addFromString($file->file_name, $fileContent);
            }
        }
        
        // 6. Tutup file zip
        $zip->close();

        // 7. Kirim file zip sebagai download dan hapus setelah terkirim
        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }

    /**
     * Render komponen (menampilkan view).
     */
    public function render()
    {
        // Ambil file milik user yang sedang login
        $files = File::where('user_id', auth()->id())
                     ->latest()
                     ->get();

        return view('livewire.photo-gallery', [
            'files' => $files
        ]);
    }
}
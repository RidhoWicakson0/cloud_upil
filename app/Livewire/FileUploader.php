<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\File;

class FileUploader extends Component
{
    use WithFileUploads;

    public $photo;
    public $showUploadModal = false; // <-- 1. Tambahkan properti status modal

    // 2. Tambahkan metode untuk MEMBUKA modal
    public function openModal()
    {
        $this->showUploadModal = true;
    }

    // 3. Tambahkan metode untuk MENUTUP modal
    public function closeModal()
    {
        $this->showUploadModal = false;
        $this->reset('photo'); // Bersihkan file input jika dibatalkan
        $this->clearValidation(); // Bersihkan error validasi
    }

    public function save()
    {
        $this->validate([
            'photo' => 'required|image|max:10240', // 10MB Max
        ]);

        $path = $this->photo->store('uploads', 'public');

        File::create([
            'user_id'   => auth()->id(),
            'file_name' => $this->photo->getClientOriginalName(),
            'path'      => $path,
            'mime_type' => $this->photo->getMimeType(),
            'size'      => $this->photo->getSize(),
        ]);

        session()->flash('status', 'File berhasil diupload!');
        $this->dispatch('file-uploaded'); // Refresh galeri
        
        $this->closeModal(); // <-- 4. Tutup modal setelah sukses upload
    }

    public function render()
    {
        return view('livewire.file-uploader');
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\File;
use Livewire\WithPagination; 

class AdminPhotoViewer extends Component
{
    use WithPagination; 

    public function render()
    {
        $files = File::with('user')->latest()->paginate(20);

        return view('livewire.admin-photo-viewer', [
            'files' => $files
        ]);
    }
}
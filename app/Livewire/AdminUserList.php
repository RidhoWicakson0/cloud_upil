<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class AdminUserList extends Component
{
    public function deleteUser($userId)
    {
        if ($userId == auth()->id()) {
            session()->flash('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
            return;
        }

        $user = User::findOrFail($userId);
        $user->delete();
        
        session()->flash('status', 'User berhasil dihapus.');
    }

    public function render()
    {
        // --- UBAH QUERY DI BAWAH INI ---
        
        // Versi Lama:
        // $users = User::where('id', '!=', auth()->id())->get();
        
        // Versi Baru (dengan kalkulasi total size):
        $users = User::where('id', '!=', auth()->id())
                     ->withSum('files', 'size') // <-- AJAIBNYA DI SINI
                     ->get();
        
        // --- SELESAI PERUBAHAN ---
        
        return view('livewire.admin-user-list', [
            'users' => $users
        ]);
    }
}
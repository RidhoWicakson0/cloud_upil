<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 1. TAMBAHKAN IMPORT INI
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 2. TAMBAHKAN RELASI KE FILES
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }


    protected function storageUsed(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Ambil nilai 'files_sum_size' yang akan kita hitung di query
                $bytes = $this->files_sum_size ?? 0;

                if ($bytes == 0) {
                    return '0 B';
                }

                $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                $i = floor(log($bytes, 1024));
                

                return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
            }
        );
    }
}
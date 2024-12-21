<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class bagian extends Model
{
    use HasFactory;
    protected $table = "bagian";
    protected $fillable = ["bagian","deskripsi"];

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class);
    }
}

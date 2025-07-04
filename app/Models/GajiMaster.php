<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiMaster extends Model
{
    use HasFactory;
    protected $table='gaji_masters';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HangBay extends Model
{
    protected $table = 'Hang_Bay';
    protected $primaryKey = 'id_hang_bay';
    public $timestamps = false;
    protected $fillable = ['ten_hang_bay', 'logo'];

    public function chuyenBayList()
    {
        return $this->hasMany(ChuyenBay::class, 'id_hang_bay', 'id_hang_bay');
    }
}

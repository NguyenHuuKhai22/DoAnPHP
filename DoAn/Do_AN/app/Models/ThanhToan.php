<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'Thanh_Toan';
    protected $primaryKey = 'id_thanh_toan';
    public $timestamps = false;
    protected $fillable = ['id_ve', 'phuong_thuc', 'so_tien', 'ngay_thanh_toan', 'trang_thai'];

    public function ve()
    {
        return $this->belongsTo(VeMayBay::class, 'id_ve', 'id_ve');
    }
}

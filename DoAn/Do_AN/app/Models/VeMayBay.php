<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VeMayBay extends Model
{
    protected $table = 'Ve_May_Bay';
    protected $primaryKey = 'id_ve';
    public $timestamps = false;
    protected $fillable = [
        'id_nguoi_dung',
        'id_chuyen_bay',
        'ma_ve',
        'loai_ghe',
        'gia_ve',
        'ngay_dat',
        'trang_thai'
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoi_dung', 'id_nguoi_dung');
    }

    public function chuyenBay()
    {
        return $this->belongsTo(ChuyenBay::class, 'id_chuyen_bay', 'id_chuyen_bay');
    }

    public function thanhToan()
    {
        return $this->hasOne(ThanhToan::class, 'id_ve', 'id_ve');
    }
}

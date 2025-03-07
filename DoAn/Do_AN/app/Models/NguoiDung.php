<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'nguoi_dung';
    protected $primaryKey = 'id_nguoi_dung';
    public $timestamps = false; // Vì bảng không có `created_at` và `updated_at`

    protected $fillable = [
        'ho_ten',
        'email',
        'password', // Đúng tên cột cần lưu
        'so_dien_thoai',
        'ngay_tao',
    ];
    

    protected $hidden = ['password'];

    // Đảm bảo Laravel sử dụng đúng mật khẩu để xác thực
    public function getAuthPassword()
    {
        return $this->password;
    }

    // Đảm bảo cột `ngay_tao` luôn có giá trị
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->ngay_tao = now();
        });
    }
}




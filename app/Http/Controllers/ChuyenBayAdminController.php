<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChuyenBay;
use App\Models\HangBay;
use Illuminate\Support\Facades\Auth;

class ChuyenBayAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Lấy thông tin user
        $flights = ChuyenBay::with('hangBay')->paginate(10);
        return view('admin.chuyenbay.index', compact('flights','user')); 
    }

    public function create()
    {
        $user = Auth::user(); // Lấy thông tin user
        $airlines = HangBay::all();
        return view('admin.chuyenbay.create', compact('airlines','user')); 
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'ma_chuyen_bay' => 'required|unique:Chuyen_Bay',
            'diem_di' => 'required',
            'diem_den' => 'required',
            'ngay_gio_khoi_hanh' => 'required|date',
            'ngay_gio_den' => 'required|date|after:ngay_gio_khoi_hanh',
            'gia_ve_co_ban' => 'required|numeric|min:0',
            'so_ghe_trong' => 'required|integer|min:0',
            'id_hang_bay' => 'required|exists:Hang_Bay,id_hang_bay'
        ]);

        ChuyenBay::create($validated);
        return redirect()->route('admin.chuyenbay.index') // Sửa route redirect
            ->with('success', 'Thêm chuyến bay thành công');
    }

    public function edit(ChuyenBay $flight)
    {
        $user = Auth::user(); // Lấy thông tin user
        $airlines = HangBay::all();
        return view('admin.chuyenbay.edit', compact('flight', 'airlines','user')); // Đổi thành admin.chuyenbay.edit
    }

    public function update(Request $request, ChuyenBay $flight)
    {
        $validated = $request->validate([
            'ma_chuyen_bay' => 'required|unique:Chuyen_Bay,ma_chuyen_bay,' . $flight->id_chuyen_bay . ',id_chuyen_bay',
            'diem_di' => 'required',
            'diem_den' => 'required',
            'ngay_gio_khoi_hanh' => 'required|date',
            'ngay_gio_den' => 'required|date|after:ngay_gio_khoi_hanh',
            'gia_ve_co_ban' => 'required|numeric|min:0',
            'so_ghe_trong' => 'required|integer|min:0',
            'id_hang_bay' => 'required|exists:Hang_Bay,id_hang_bay'
        ]);

        $flight->update($validated);
        return redirect()->route('admin.chuyenbay.index') // Sửa route redirect
            ->with('success', 'Cập nhật chuyến bay thành công');
    }

    public function destroy(ChuyenBay $flight)
    {
        $user = Auth::user(); // Lấy thông tin user
        $flight->delete(); // Sử dụng soft delete thay vì xóa cứng
        return redirect()->route('admin.chuyenbay.index')
            ->with('success', 'Đã xóa mềm chuyến bay thành công');
    }

    // (Tùy chọn) Thêm phương thức để xem danh sách đã xóa mềm
    public function trashed()
    { $user = Auth::user(); // Lấy thông tin user
        $flights = ChuyenBay::onlyTrashed()->with('hangBay')->paginate(10); // Lấy các bản ghi đã xóa mềm
        return view('admin.chuyenbay.trashed', compact('flights','user'));
    }

    // (Tùy chọn) Khôi phục bản ghi đã xóa mềm
    public function restore($id)
    {
        $user = Auth::user(); // Lấy thông tin user
        $flight = ChuyenBay::withTrashed()->findOrFail($id);
        $flight->restore();
        return redirect()->route('admin.chuyenbay.trashed')
            ->with('success', 'Đã khôi phục chuyến bay thành công');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NguoiDung;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    

public function register(Request $request)
{
    try {
        $validatedData = $request->validate([
            'ho_ten' => 'required|string|max:100',
            'email' => 'required|email|unique:nguoi_dung,email',
            'password' => 'required|min:6',
            'so_dien_thoai' => 'nullable|string|max:15'
        ]);

        $user = NguoiDung::create([
            'ho_ten' => $validatedData['ho_ten'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'so_dien_thoai' => $validatedData['so_dien_thoai'] ?? null,
            'ngay_tao' => now(),
        ]);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Đăng ký thất bại, vui lòng thử lại!']);
        }

        Auth::login($user);
        return response()->json(['success' => true, 'message' => 'Đăng ký thành công!']);

    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors() // Trả về danh sách lỗi cụ thể
        ], 422);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại!']);
    }
}

    

    

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            // Xác thực dữ liệu đầu vào
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            $user = NguoiDung::where('email', $validatedData['email'])->first();
    
            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Thông tin đăng nhập không chính xác'
                ]);
            }
    
            Auth::login($user);
            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công!'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors() // Trả về danh sách lỗi cụ thể
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ]);
        }
    }
    


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\front\LoginRequest;
use App\Http\Requests\front\RegisterRequest;
use App\Mail\ResetPassword;
use App\Mail\SendVerificationMasyarakatMail;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FrontAuthController extends Controller
{
    public function index()
    {
        return view('front.auth.login');
    }


    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $masyarakat = Masyarakat::where('email', $request->email)->first();

        if (!$masyarakat) {
            return redirect()->back()->with('error', 'Login gagal, silahkan coba lagi');
        }

        if (!$masyarakat->verified_at) {
            return redirect()->back()->with('error', 'Login gagal, silahkan verifikasi akun anda terlebih dahulu');
        }

        if (auth('masyarakat')->attempt($credentials)) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('error', 'Login gagal, silahkan coba lagi');
        }
    }

    public function register()
    {
        return view('front.auth.register');
    }
    public function register_store(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $masyarakat = Masyarakat::create([
                'nik' => $request->nik,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'verification_token' => uuid_create(),
                'verification_token_expires_at' => now()->addMinutes(15),
            ]);

            $mail = new SendVerificationMasyarakatMail(base64_encode($masyarakat->verification_token));
            Mail::to($masyarakat->email)->send($mail);
            DB::commit();
            return redirect()->route('front.register')->with('success', 'Register berhasil, silahkan verifikasi akun anda');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Register gagal, silahkan coba lagi");
        }
    }

    public function verify($token)
    {
        $token = base64_decode($token);
        $masyarakat = Masyarakat::where('verification_token', $token)->first();
        if ($masyarakat) {
            $masyarakat->update([
                'verified_at' => now(),
                'verification_token' => null,
                'verification_token_expires_at' => null,
            ]);
            auth('masyarakat')->login($masyarakat);
            return redirect()->route('home')->with('success', 'Verifikasi berhasil');
        }
        return redirect()->route('home')->with('error', 'Verifikasi gagal');
    }

    public function logout()
    {
        auth('masyarakat')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('home');
    }

    public function forgot_password()
    {
        return view('front.auth.forgot_password');
    }

    public function forgot_password_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $checkemail = Masyarakat::where('email', $request->email)->first();
        if (!$checkemail) {
            return redirect()->back()->withErrors([
                'email' => 'Email tidak ditemukan',
            ])->withInput();
        }

        $checkemail->update([
            'reset_token' => $checkemail->id . '_' . $checkemail->email . '_' . uuid_create(),
        ]);

        $token = base64_encode($checkemail->reset_token);
        $mail = new ResetPassword($token);
        Mail::to($checkemail->email)->send($mail);

        return redirect()->route('front.auth.forgot_password')->with('success', 'Silahkan cek email anda untuk reset password');
    }

    public function reset_password($token)
    {
        $token = base64_decode($token);

        $split = explode('_', $token);

        $email = $split[1];
        $id = $split[0];
        $check = Masyarakat::where('email', $email)->where('id', $id)->where('reset_token', $token)->first();

        if (!$check) {
            return abort(404);
        }

        return view('front.auth.reset_password', [
            'token' => $token
        ]);
    }

    public function reset_password_store(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'konfirmation_password' => 'required|same:password',
        ], [
            'token.required' => 'Token tidak ditemukan',
            'password.required' => 'Password tidak boleh kosong',
            'password.confirmed' => 'Password tidak cocok',
            'konfirmation_password.required' => 'Konfirmasi password tidak boleh kosong',
            'konfirmation_password.same' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $token = base64_decode($request->token);

        $split = explode('_', $token);

        $email = $split[1];
        $id = $split[0];
        $check = Masyarakat::where('email', $email)->where('id', $id)->where('reset_token', $token)->first();

        if (!$check) {
            return abort(404);
        }

        $check->update([
            'password' => Hash::make($request->password),
            'reset_token' => null,
        ]);

        return redirect()->route('front.login')->with('success', 'Reset password berhasil');
    }


    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nik' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $user = auth('masyarakat')->user();
        $user->update([
            'name' => $request->name,
            'nik' => $request->nik,
            'email' => $request->email,
            'address' => $request->alamat,
            'phone' => $request->phone
        ]);
        return redirect()->route('front.profile')->with('success', 'Profile berhasil diupdate');
    }
}

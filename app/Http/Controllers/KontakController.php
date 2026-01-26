<?php

namespace App\Http\Controllers;

use App\Models\PesanKontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KontakController extends Controller
{
    /**
     * Menampilkan halaman kontak.
     */
    public function show()
    {
        return view('pages.kontak');
    }

    /**
     * Menyimpan pesan kontak via AJAX.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal 10 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            PesanKontak::create([
                'nama' => $request->name,
                'email' => $request->email,
                'subjek' => $request->subject,
                'pesan' => $request->message,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.'
            ], 500);
        }
    }
}

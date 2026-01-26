<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

class PesanKontakController extends Controller
{
    /**
     * Menampilkan daftar semua pesan kontak.
     */
    public function index()
    {
        $pesan = PesanKontak::orderBy('created_at', 'desc')
            ->get();

        return view('admin.pesan-kontak.index', compact('pesan'));
    }

    /**
     * Menampilkan detail pesan dan tandai sudah dibaca.
     */
    public function show($id)
    {
        $pesan = PesanKontak::findOrFail($id);

        // Mark as read if not already
        if (!$pesan->is_read) {
            $pesan->update(['is_read' => true]);
        }

        return view('admin.pesan-kontak.show', compact('pesan'));
    }

    /**
     * Menghapus pesan kontak.
     */
    public function destroy($id)
    {
        $pesan = PesanKontak::findOrFail($id);
        $pesan->delete();

        return redirect()->route('admin.pesan-kontak')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}

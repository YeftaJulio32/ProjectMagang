<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class BeritaController extends Controller
{
    public function index()
    {
        // Contoh endpoint API (ganti dengan endpoint asli Anda)
        $response = Http::get('https://api.example.com/berita');

        if ($response->successful()) {
            $berita = $response->json();
            return view('berita.index', compact('berita'));
        } else {
            return view('berita.index', ['error' => 'Gagal memuat data berita.']);
        }
    }
}

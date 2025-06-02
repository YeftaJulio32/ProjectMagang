<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        // Step 1: Login ke API untuk dapetin api_key
        $loginResponse = Http::post('https://winnicode.com/api/login', [
            'email' => 'dummy@dummy.com',
            'password' => 'dummy'
        ]);

        // Cek apakah login berhasil
        if ($loginResponse->successful()) {
            $apiKey = $loginResponse->json()['api_key'] ?? null;

            if ($apiKey) {
                // Step 2: Ambil berita pakai Bearer Token
                $newsResponse = Http::withToken($apiKey)->get('https://winnicode.com/api/publikasi-berita');

                if ($newsResponse->successful()) {
                    $news = $newsResponse->json();

                    // Convert ke collection biar gampang diolah
                    $newsCollection = collect($news);

                    // Ambil 1 berita utama paling atas
                    $headline = $newsCollection->first();

                    // Ambil sisanya & kelompokkan per kategori
                    $groupedNews = $newsCollection->slice(1)->groupBy('kategori');

                    // Kirim ke view
                    return view('welcome', [
                        'headline' => $headline,
                        'groupedNews' => $groupedNews
                    ]);
                } else {
                    return view('welcome', [
                        'headline' => null,
                        'groupedNews' => collect()
                    ]);
                }
            } else {
                return response()->json(['error' => 'Gagal mendapatkan API Key'], 500);
            }
        } else {
            return response()->json(['error' => 'Login gagal'], 500);
        }
    }

    public function show($id)
    {
        // Step 1: Login untuk dapatkan API Key
        $loginResponse = Http::post('https://winnicode.com/api/login', [
            'email' => 'dummy@dummy.com',
            'password' => 'dummy'
        ]);

        if (!$loginResponse->successful()) {
            return abort(500, 'Login API gagal');
        }

        $apiKey = $loginResponse->json()['api_key'] ?? null;

        if (!$apiKey) {
            return abort(500, 'API Key tidak ditemukan');
        }

        // Step 2: Ambil semua berita
        $response = Http::withToken($apiKey)->get('https://winnicode.com/api/publikasi-berita');
        $newsList = $response->successful() ? $response->json() : [];

        // Step 3: Cari berita berdasarkan ID
        $selectedNews = collect($newsList)->firstWhere('id', $id);

        if (!$selectedNews) {
            return abort(404, 'Berita tidak ditemukan');
        }

        // Step 4: Ambil berita lain dari kategori yang sama, tapi beda ID
        $otherNews = collect($newsList)
            ->where('kategori', $selectedNews['kategori'] ?? null)
            ->where('id', '!=', $id)
            ->take(4)
            ->values()
            ->all();

        return view('detail', [
            'news' => $selectedNews,
            'otherNews' => $otherNews
        ]);
    }
}

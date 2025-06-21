<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NewsController extends Controller
{
    private function getApiKey()
    {
        return Cache::remember('winnicode_api_key', 3600, function () {
            $response = Http::post('https://winnicode.com/api/login', [
                'email' => 'dummy@dummy.com',
                'password' => 'dummy'
            ]);

            if ($response->successful()) {
                return $response->json()['api_key'] ?? null;
            }

            Log::error('Login API gagal', ['response' => $response->body()]);
            return null;
        });
    }

    public function index()
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            return response()->json(['error' => 'Gagal mendapatkan API Key'], 500);
        }

        $newsResponse = Http::withToken($apiKey)->get('https://winnicode.com/api/publikasi-berita');

        if (!$newsResponse->successful()) {
            Log::error('Gagal mengambil data berita', ['response' => $newsResponse->body()]);
            return view('welcome', [
                'headline' => null,
                'groupedNews' => collect(),
                'availableCategories' => collect()
            ]);
        }

        $newsCollection = collect($newsResponse->json());
        $headline = $newsCollection->first();
        $groupedNews = $newsCollection->slice(1)->groupBy('kategori');

        // Ambil semua kategori yang tersedia dari API
        $availableCategories = $newsCollection
            ->pluck('kategori')
            ->unique()
            ->filter()
            ->values();

        return view('welcome', [
            'headline' => $headline,
            'groupedNews' => $groupedNews,
            'availableCategories' => $availableCategories
        ]);
    }

    public function show($id)
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            return abort(500, 'API Key tidak ditemukan');
        }

        $response = Http::withToken($apiKey)->get('https://winnicode.com/api/publikasi-berita');
        $newsList = $response->successful() ? $response->json() : [];

        $selectedNews = collect($newsList)->firstWhere('id', $id);

        if (!$selectedNews) {
            return abort(404, 'Berita tidak ditemukan');
        }

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

    public function kategori($kategori)
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            return abort(500, 'API Key tidak ditemukan');
        }

        $response = Http::withToken($apiKey)->get('https://winnicode.com/api/publikasi-berita');
        $newsList = $response->successful() ? $response->json() : [];

        if (empty($newsList)) {
            return view('kategori', [
                'kategori' => $kategori,
                'filteredNews' => collect(),
                'availableCategories' => collect(),
                'error' => 'Tidak ada berita yang tersedia dari API.'
            ]);
        }

        // Filter berita sesuai kategori
        $filteredNews = collect($newsList)->filter(function ($news) use ($kategori) {
            $isInCategory = isset($news['kategori']) && strtolower($news['kategori']) === strtolower($kategori);
            return $isInCategory;
        });

        // Ambil semua kategori yang tersedia dari API
        $availableCategories = collect($newsList)
            ->pluck('kategori')
            ->unique()
            ->filter()
            ->map(function ($cat) {
                return strtolower($cat);
            })
            ->values();

        return view('kategori', [
            'kategori' => $kategori,
            'filteredNews' => $filteredNews,
            'availableCategories' => $availableCategories
        ]);
    }
}

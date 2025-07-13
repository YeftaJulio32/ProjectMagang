<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Comment;

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

    private function getNewsList($apiKey)
    {
        $response = Http::withToken($apiKey)->get('https://winnicode.com/api/publikasi-berita');
        return $response->successful() ? collect($response->json()) : collect();
    }

    public function index()
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            return response()->json(['error' => 'Gagal mendapatkan API Key'], 500);
        }

        $newsCollection = $this->getNewsList($apiKey);

        if ($newsCollection->isEmpty()) {
            Log::error('Gagal mengambil data berita');
            return view('news.index', [
                'headline' => null,
                'groupedNews' => collect(),
                'availableCategories' => collect()
            ]);
        }

        $headline = $newsCollection->first();
        $groupedNews = $newsCollection->slice(1)->groupBy('kategori');
        $availableCategories = $newsCollection->pluck('kategori')->unique()->filter()->values();

        return view('news.index', [
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

        $newsCollection = $this->getNewsList($apiKey);

        $selectedNews = $newsCollection->firstWhere('id', $id);

        if (!$selectedNews) {
            return abort(404, 'Berita tidak ditemukan');
        }

        $otherNews = $newsCollection
            ->where('kategori', $selectedNews['kategori'] ?? null)
            ->where('id', '!=', $id)
            ->take(4)
            ->values()
            ->all();

        $comments = Comment::where('post_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('news.show', [
            'news' => $selectedNews,
            'otherNews' => $otherNews,
            'comments' => $comments
        ]);
    }

    public function kategori($kategori)
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            return abort(500, 'API Key tidak ditemukan');
        }

        $newsCollection = $this->getNewsList($apiKey);

        if ($newsCollection->isEmpty()) {
            return view('news.kategori', [
                'kategori' => $kategori,
                'filteredNews' => collect(),
                'availableCategories' => collect(),
                'error' => 'Tidak ada berita yang tersedia dari API.'
            ]);
        }

        $filteredNews = $newsCollection->filter(function ($news) use ($kategori) {
            return isset($news['kategori']) && \Illuminate\Support\Str::slug($news['kategori']) === $kategori;
        });

        $originalCategory = $filteredNews->isNotEmpty()
            ? $filteredNews->first()['kategori']
            : $newsCollection->first(function ($news) use ($kategori) {
                return isset($news['kategori']) && \Illuminate\Support\Str::slug($news['kategori']) === $kategori;
            })['kategori'] ?? null;

        $availableCategories = $newsCollection->pluck('kategori')->unique()->filter()->values();

        return view('news.kategori', [
            'kategori' => $originalCategory ?? ucfirst(str_replace('-', ' ', $kategori)),
            'filteredNews' => $filteredNews,
            'availableCategories' => $availableCategories
        ]);
    }
}

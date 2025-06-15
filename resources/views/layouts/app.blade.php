<!DOCTYPE html>
{{-- Hapus data-bs-theme dari sini agar bisa dikontrol oleh JavaScript --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Winnews - @yield('title', 'Portal Berita Terkini')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    {{-- Memanggil Header --}}
    @include('layouts.header')

    <main>
        {{-- Area Konten Spesifik Halaman --}}
        @yield('content')
    </main>

    {{-- Memanggil Footer --}}
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- [BARU] Skrip untuk Pengalih Tema Terang/Gelap -->
    <script>
        (() => {
            'use strict'

            // Fungsi untuk mendapatkan tema yang tersimpan di localStorage
            const getStoredTheme = () => localStorage.getItem('theme')
            // Fungsi untuk menyimpan tema ke localStorage
            const setStoredTheme = theme => localStorage.setItem('theme', theme)

            // Fungsi untuk mendapatkan tema yang seharusnya diterapkan
            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme()
                if (storedTheme) {
                    return storedTheme
                }
                // Jika tidak ada tema tersimpan, gunakan preferensi sistem, atau default ke 'light'
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            }

            // Fungsi untuk mengatur tema pada elemen <html> dan ikon tombol
            const setTheme = theme => {
                // Atur tema pada <html>
                document.documentElement.setAttribute('data-bs-theme', theme)

                // Perbarui ikon pada tombol
                const sunIcon = document.querySelector('#theme-toggle .bi-sun-fill')
                const moonIcon = document.querySelector('#theme-toggle .bi-moon-stars-fill')

                if (sunIcon && moonIcon) {
                    if (theme === 'dark') {
                        sunIcon.classList.remove('d-none')
                        moonIcon.classList.add('d-none')
                    } else {
                        sunIcon.classList.add('d-none')
                        moonIcon.classList.remove('d-none')
                    }
                }
            }

            // Atur tema saat halaman dimuat
            setTheme(getPreferredTheme())

            // Tambahkan event listener untuk tombol pengalih tema
            const themeToggler = document.getElementById('theme-toggle')
            if(themeToggler) {
                themeToggler.addEventListener('click', () => {
                    const currentTheme = getStoredTheme() || getPreferredTheme()
                    const newTheme = currentTheme === 'light' ? 'dark' : 'light'
                    setStoredTheme(newTheme)
                    setTheme(newTheme)
                })
            }

            // Juga, dengarkan perubahan preferensi sistem
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (!getStoredTheme()) { // Hanya jika pengguna belum memilih secara manual
                    setTheme(getPreferredTheme())
                }
            })
        })()
    </script>
</body>
</html>

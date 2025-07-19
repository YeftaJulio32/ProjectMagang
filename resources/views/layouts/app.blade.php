<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Winnews - @yield('title', 'Portal Berita Terkini')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Header --}}
    @include('layouts.header')

    {{-- Konten utama --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Theme Toggle Script -->
    <script>
        (() => {
            'use strict'
            const getStoredTheme = () => localStorage.getItem('theme')
            const setStoredTheme = theme => localStorage.setItem('theme', theme)
            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme()
                if (storedTheme) return storedTheme
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            }
            const setTheme = theme => {
                document.documentElement.setAttribute('data-bs-theme', theme)
                const sun = document.querySelector('#theme-toggle .bi-sun-fill')
                const moon = document.querySelector('#theme-toggle .bi-moon-stars-fill')
                if (sun && moon) {
                    sun.classList.toggle('d-none', theme !== 'dark')
                    moon.classList.toggle('d-none', theme === 'dark')
                }
            }
            setTheme(getPreferredTheme())
            const toggler = document.getElementById('theme-toggle')
            if (toggler) {
                toggler.addEventListener('click', () => {
                    const current = getStoredTheme() || getPreferredTheme()
                    const next = current === 'light' ? 'dark' : 'light'
                    setStoredTheme(next)
                    setTheme(next)
                })
            }
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (!getStoredTheme()) setTheme(getPreferredTheme())
            })
        })()
    </script>
</body>
</html>

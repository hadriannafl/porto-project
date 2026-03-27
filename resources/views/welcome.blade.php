<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IanDev — Ian Dev</title>
        <meta name="description" content="Full Stack Developer specializing in Vue.js and Laravel. Building modern, high-performance web applications.">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { font-family: 'Inter', sans-serif; }
            html { scroll-behavior: smooth; }
        </style>
        <script>window.__IS_ADMIN__ = {{ $isAdmin ? 'true' : 'false' }}</script>
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>

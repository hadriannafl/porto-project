<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gray-950 flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <!-- Logo -->
        <div class="text-center mb-8">
            <span class="text-2xl font-black bg-gradient-to-r from-violet-500 to-cyan-400 bg-clip-text text-transparent">
                &lt;IanDev /&gt;
            </span>
            <p class="text-gray-500 text-sm mt-2">Admin Access</p>
        </div>

        <!-- Card -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8">
            <h1 class="text-white text-xl font-bold mb-6">Enter Admin Password</h1>

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-xl bg-red-950/50 border border-red-800 text-red-400 text-sm">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <input type="password" name="password" autofocus
                        class="w-full px-4 py-3 rounded-xl bg-gray-800 border border-gray-700 text-white placeholder-gray-500 text-sm outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 transition-all"
                        placeholder="Enter your password">
                </div>
                <button type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 text-white font-semibold hover:opacity-90 transition-opacity">
                    Login →
                </button>
            </form>
        </div>

        <p class="text-center text-gray-600 text-xs mt-6">
            This page is not publicly advertised.
        </p>
    </div>
</body>
</html>

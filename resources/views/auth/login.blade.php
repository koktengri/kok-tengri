<!doctype html>
<html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Giriş yap · Kök Tengri</title><script src="https://cdn.tailwindcss.com"></script><link rel="stylesheet" href="{{ asset('css/repost-theme.css') }}">
</head>
<body class="kt-repost" class="bg-white text-slate-900"><main class="mx-auto max-w-lg px-5 py-12"><a href="/" class="font-bold text-blue-700">← Kök Tengri</a><h1 class="mt-8 text-3xl font-bold">Tekrar hoş geldin</h1><p class="mt-2 text-slate-600">Topluluğa devam etmek için giriş yap.</p>
@if ($errors->any())<div class="mt-5 rounded border border-red-200 bg-red-50 p-3 text-red-700">@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<form method="post" action="{{ route('login') }}" class="mt-6 space-y-4">@csrf
<label class="block text-sm font-medium">E-posta<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-3"></label>
<label class="block text-sm font-medium">Şifre<input type="password" name="password" required autocomplete="current-password" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-3"></label>
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" value="1"> Beni hatırla</label>
<button class="w-full rounded-lg bg-blue-700 px-4 py-3 font-semibold text-white hover:bg-blue-800">Giriş yap</button></form><p class="mt-5 text-sm text-slate-600">Hesabın yok mu? <a class="text-blue-700 underline" href="{{ route('register') }}">Üye ol</a></p></main></body></html>

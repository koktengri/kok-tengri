<!doctype html>
<html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Üye ol · Kök Tengri</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-white text-slate-900"><main class="mx-auto max-w-lg px-5 py-12"><a href="/" class="font-bold text-blue-700">← Kök Tengri</a><h1 class="mt-8 text-3xl font-bold">Topluluğa katıl</h1><p class="mt-2 text-slate-600">Hesabını oluştur, yazı paylaş ve sohbete katıl.</p>
@if ($errors->any())<div class="mt-5 rounded border border-red-200 bg-red-50 p-3 text-red-700">@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<form method="post" action="{{ route('register') }}" class="mt-6 space-y-4">@csrf
<label class="block text-sm font-medium">Adın<input name="name" value="{{ old('name') }}" required maxlength="80" autocomplete="name" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-3"></label>
<label class="block text-sm font-medium">E-posta<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-3"></label>
<label class="block text-sm font-medium">Şifre (en az 10 karakter)<input type="password" name="password" required minlength="10" autocomplete="new-password" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-3"></label>
<label class="block text-sm font-medium">Şifreyi tekrar gir<input type="password" name="password_confirmation" required minlength="10" autocomplete="new-password" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-3"></label>
<button class="w-full rounded-lg bg-blue-700 px-4 py-3 font-semibold text-white hover:bg-blue-800">Üyeliği oluştur</button></form><p class="mt-5 text-sm text-slate-600">Zaten üye misin? <a class="text-blue-700 underline" href="{{ route('login') }}">Giriş yap</a></p></main></body></html>

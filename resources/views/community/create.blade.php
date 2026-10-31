<!doctype html>
<html lang="tr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Yeni gönderi · Kök Tengri</title><script src="https://cdn.tailwindcss.com"></script>    <link rel="stylesheet" href="{{ asset('css/repost-theme.css') }}">
</head>
<body class="kt-repost" class="kt-repost" class="bg-slate-50 text-slate-900"><main class="mx-auto max-w-3xl px-4 py-8"><a href="/" class="font-semibold text-blue-700">← Akışa dön</a><h1 class="mt-5 text-3xl font-bold">Yeni gönderi</h1>
@if ($errors->any())<div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-3 text-red-700">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<form method="post" action="{{ route('posts.store') }}" class="mt-6 space-y-5 rounded-xl border bg-white p-5">@csrf
<label class="block font-medium">Başlık<input name="title" required maxlength="180" value="{{ old('title') }}" class="mt-2 w-full rounded-lg border px-3 py-3 text-base"></label>
<label class="block font-medium">Kısa açıklama <span class="font-normal text-slate-500">(isteğe bağlı)</span><textarea name="excerpt" rows="2" maxlength="500" class="mt-2 w-full rounded-lg border px-3 py-3">{{ old('excerpt') }}</textarea></label>
<label class="block font-medium">İçerik<textarea name="body" rows="12" required minlength="20" maxlength="50000" class="mt-2 w-full rounded-lg border px-3 py-3" placeholder="Düşüncelerini paylaş...">{{ old('body') }}</textarea><span class="mt-1 block text-xs text-slate-500">Düz metin olarak yayımlanır.</span></label>
<label class="block font-medium">Kategori<select name="category_id" class="mt-2 w-full rounded-lg border px-3 py-3"><option value="">Kategori seç (isteğe bağlı)</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select></label>
<label class="block font-medium">Etiketler <span class="font-normal text-slate-500">(virgülle ayır, en fazla 8)</span><input name="tags" value="{{ old('tags') }}" placeholder="kültür, tarih, düşünce" class="mt-2 w-full rounded-lg border px-3 py-3"></label>
<button class="rounded-lg bg-blue-700 px-5 py-3 font-semibold text-white hover:bg-blue-800">Yayımla</button></form></main></body></html>

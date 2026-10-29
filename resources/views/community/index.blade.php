<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kök Tengri — kültür, tarih ve fikirler üzerine bağımsız topluluk. Oku, paylaş, tartış.">
    <title>Kök Tengri — Fikirlerin buluştuğu yer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body{font-family:Inter,ui-sans-serif,system-ui,sans-serif}
        .line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .line-clamp-3{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
    </style>
</head>
<body class="min-h-screen bg-[#f7f8fa] text-[#20242b] antialiased">
<header class="sticky top-0 z-30 border-b border-slate-200 bg-white">
    <div class="mx-auto flex h-[68px] max-w-[1440px] items-center gap-5 px-4 sm:px-6">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5" aria-label="Kök Tengri ana sayfa">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#234e8a] text-lg font-extrabold text-white">K</span>
            <span class="text-[19px] font-extrabold tracking-tight">kök tengri</span>
        </a>
        <form action="{{ route('home') }}" method="get" class="hidden min-w-0 max-w-xl flex-1 md:block">
            <label class="flex h-10 items-center gap-2.5 rounded-lg border border-slate-200 bg-slate-50 px-3.5 focus-within:border-slate-400">
                <svg class="h-[17px] w-[17px] shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 4 4"></path></svg>
                <input name="q" value="{{ request('q') }}" type="search" placeholder="Gönderilerde ara..." class="w-full bg-transparent text-sm outline-none placeholder:text-slate-400">
                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
            </label>
        </form>
        <nav class="ml-auto flex items-center gap-2 text-sm">
            <a href="{{ route('home') }}" class="hidden rounded-lg px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 sm:inline-flex">Keşfet</a>
            <a href="{{ route('members.index') }}" class="hidden rounded-lg px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 sm:inline-flex">Üyeler</a>
            @auth
                <a href="{{ route('bookmarks.index') }}" class="hidden rounded-lg px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 sm:inline-flex">Kaydedilenler</a>
                @if(auth()->user()->hasRole('admin', 'editor'))
                    <a href="{{ route('community.admin.comments.pending') }}" class="hidden rounded-lg px-3 py-2 font-medium text-slate-600 hover:bg-slate-100 lg:inline-flex">Moderasyon</a>
                @endif
                <a href="{{ route('posts.create') }}" class="inline-flex h-10 items-center gap-2 rounded-lg bg-[#234e8a] px-3.5 font-semibold text-white hover:bg-[#193e72] sm:px-4">
                    <span class="text-lg leading-none">+</span><span>Yazı yaz</span>
                </a>
                <div class="hidden items-center gap-2 border-l border-slate-200 pl-3 lg:flex">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#e7edf6] text-xs font-bold text-[#234e8a]">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="max-w-[120px] truncate font-medium">{{ auth()->user()->name }}</span>
                </div>
                <form method="post" action="{{ route('logout') }}" class="hidden sm:block">@csrf<button class="rounded-lg px-2 py-2 text-slate-500 hover:bg-slate-100">Çıkış</button></form>
            @else
                <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 font-semibold text-slate-700 hover:bg-slate-100">Giriş yap</a>
                <a href="{{ route('register') }}" class="inline-flex h-10 items-center rounded-lg bg-[#234e8a] px-4 font-semibold text-white hover:bg-[#193e72]">Katıl</a>
            @endauth
        </nav>
    </div>
    <form action="{{ route('home') }}" method="get" class="border-t border-slate-100 px-4 py-2 md:hidden">
        <label class="flex h-9 items-center gap-2 rounded-lg bg-slate-100 px-3">
            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"></circle><path d="m16 16 4 4"></path></svg>
            <input name="q" value="{{ request('q') }}" type="search" placeholder="Toplulukta ara..." class="w-full bg-transparent text-sm outline-none">
        </label>
    </form>
</header>

<main class="mx-auto max-w-[1440px] px-4 py-6 sm:px-6 lg:py-8">
    <section class="mb-7 border-b border-slate-200 pb-7">
        <div class="max-w-3xl">
            <p class="mb-3 text-xs font-bold uppercase tracking-[.16em] text-[#234e8a]">Bağımsız topluluk</p>
            <h1 class="text-[32px] font-extrabold leading-tight tracking-[-.04em] sm:text-[42px]">Fikirler burada kök salar.</h1>
            <p class="mt-3 max-w-2xl text-[15px] leading-7 text-slate-600 sm:text-base">Tarih, kültür, teknoloji ve gündem üzerine oku; kendi deneyimini paylaş, farklı fikirlerle tanış.</p>
            <div class="mt-5 flex flex-wrap items-center gap-3">
                @auth
                    <a href="{{ route('posts.create') }}" class="inline-flex h-10 items-center rounded-lg bg-[#234e8a] px-4 text-sm font-semibold text-white hover:bg-[#193e72]">Topluluğa yaz</a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex h-10 items-center rounded-lg bg-[#234e8a] px-4 text-sm font-semibold text-white hover:bg-[#193e72]">Ücretsiz katıl</a>
                @endauth
                <span class="text-sm text-slate-500">Okumak için hesap gerekmez.</span>
            </div>
        </div>
    </section>

    @if(session('status'))
        <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
    @endif

    <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-[210px_minmax(0,1fr)_270px] xl:gap-8">
        <aside class="hidden lg:block">
            <div class="sticky top-[92px]">
                <p class="mb-3 px-3 text-[11px] font-bold uppercase tracking-[.14em] text-slate-400">Keşfet</p>
                <nav class="space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm {{ !request('category') ? 'bg-[#eaf0f8] font-semibold text-[#234e8a]' : 'text-slate-600 hover:bg-white' }}">
                        <span class="w-5 text-center">⌂</span> Tüm gönderiler
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('home', array_filter(['category' => $category->slug, 'q' => request('q')])) }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm {{ request('category') === $category->slug ? 'bg-[#eaf0f8] font-semibold text-[#234e8a]' : 'text-slate-600 hover:bg-white' }}">
                            <span class="w-5 text-center text-slate-400">#</span><span class="truncate">{{ $category->name }}</span>
                        </a>
                    @endforeach
                </nav>
                @auth
                    <div class="mt-7 border-t border-slate-200 pt-5">
                        <p class="mb-3 px-3 text-[11px] font-bold uppercase tracking-[.14em] text-slate-400">Hesabım</p>
                        <a href="{{ route('bookmarks.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-600 hover:bg-white"><span class="w-5 text-center">▱</span> Kaydedilenler</a>
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('community.admin.members') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-slate-600 hover:bg-white"><span class="w-5 text-center">⚙</span> Üyeleri yönet</a>
                        @endif
                    </div>
                @endauth
                <div class="mt-8 px-3 text-xs leading-6 text-slate-400">Kök Tengri<br>Fikirlerin, deneyimlerin ve merakın buluştuğu yer.</div>
            </div>
        </aside>

        <section class="min-w-0">
            <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold tracking-tight">{{ request('q') ? 'Arama sonuçları' : (request('category') ? ($categories->firstWhere('slug', request('category'))->name ?? 'Kategori') : 'Topluluktan son yazılar') }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $posts->total() }} gönderi</p>
                </div>
                <form action="{{ route('home') }}" method="get" class="flex items-center gap-2">
                    @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    <label for="sort" class="text-xs text-slate-500">Sırala</label>
                    <select id="sort" name="sort" onchange="this.form.submit()" class="h-9 rounded-lg border border-slate-200 bg-white px-2 text-sm outline-none focus:border-slate-400">
                        <option value="new" @selected(request('sort', 'new') === 'new')>En yeni</option>
                        <option value="popular" @selected(request('sort') === 'popular')>En çok görüntülenen</option>
                    </select>
                </form>
            </div>

            @forelse($posts as $post)
                <article class="mb-4 border border-slate-200 bg-white p-5 transition-colors hover:border-slate-300 sm:rounded-xl sm:p-6">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#eaf0f8] text-sm font-bold text-[#234e8a]">{{ mb_strtoupper(mb_substr($post->author->name, 0, 1)) }}</div>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-slate-500">
                                <a href="{{ route('members.show', $post->author) }}" class="font-semibold text-slate-800 hover:text-[#234e8a]">{{ $post->author->name }}</a><span>·</span>
                                <time datetime="{{ $post->published_at?->toIso8601String() }}">{{ optional($post->published_at)->diffForHumans() ?? $post->created_at->diffForHumans() }}</time>
                                @if($post->category)<span>·</span><a href="{{ route('home', ['category' => $post->category->slug]) }}" class="text-[#234e8a] hover:underline">{{ $post->category->name }}</a>@endif
                            </div>
                            <h3 class="mt-2 text-[18px] font-bold leading-snug tracking-[-.02em] sm:text-xl"><a href="{{ route('posts.show', $post) }}" class="hover:text-[#234e8a]">{{ $post->title }}</a></h3>
                            @if($post->excerpt)
                                <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-600">{{ $post->excerpt }}</p>
                            @else
                                <p class="mt-2 line-clamp-3 text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($post->body), 260) }}</p>
                            @endif
                            @if($post->tags->isNotEmpty())
                                <div class="mt-3 flex flex-wrap gap-2">@foreach($post->tags as $tag)<a href="{{ route('home', ['q' => $tag->name]) }}" class="rounded-md bg-slate-100 px-2 py-1 text-xs text-slate-600 hover:bg-slate-200">#{{ $tag->name }}</a>@endforeach</div>
                            @endif
                            <div class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 border-t border-slate-100 pt-3 text-xs text-slate-500">
                                <a href="{{ route('posts.show', $post) }}#comments" class="inline-flex items-center gap-1.5 hover:text-slate-900"><span>◯</span>{{ $post->comments_count }} yorum</a>
                                <span class="inline-flex items-center gap-1.5"><span>♡</span>{{ $post->reactions_count }} tepki</span>
                                <span class="inline-flex items-center gap-1.5"><span>↗</span>{{ number_format($post->views_count) }} görüntülenme</span>
                                <a href="{{ route('posts.show', $post) }}" class="ml-auto font-semibold text-[#234e8a] hover:underline">Devamını oku <span aria-hidden="true">→</span></a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="border border-dashed border-slate-300 bg-white px-6 py-14 text-center sm:rounded-xl">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-xl text-slate-500">⌕</div>
                    <h3 class="mt-4 text-lg font-bold">Burada henüz bir şey yok</h3>
                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">Aradığını bulamadıysan başka bir kelime dene ya da topluluğun ilk gönderisini sen paylaş.</p>
                    <div class="mt-5 flex justify-center gap-3"><a href="{{ route('home') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Akışa dön</a>@auth<a href="{{ route('posts.create') }}" class="rounded-lg bg-[#234e8a] px-4 py-2 text-sm font-semibold text-white">İlk yazıyı paylaş</a>@else<a href="{{ route('register') }}" class="rounded-lg bg-[#234e8a] px-4 py-2 text-sm font-semibold text-white">Topluluğa katıl</a>@endauth</div>
                </div>
            @endforelse
            <div class="mt-6">{{ $posts->withQueryString()->links() }}</div>
        </section>

        <aside class="space-y-5">
            <section class="border border-slate-200 bg-white p-5 sm:rounded-xl">
                <h2 class="text-sm font-bold">Kök Tengri topluluğu</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Bilgini paylaş, yeni şeyler öğren, konuşmaya dahil ol. Her katkı burada bir iz bırakır.</p>
                <div class="mt-5 grid grid-cols-2 gap-3 border-y border-slate-100 py-4">
                    <div><p class="text-2xl font-extrabold tracking-tight">{{ number_format($memberCount) }}</p><p class="mt-1 text-xs text-slate-500">Üye</p></div>
                    <div><p class="text-2xl font-extrabold tracking-tight">{{ number_format($publishedCount) }}</p><p class="mt-1 text-xs text-slate-500">Gönderi</p></div>
                </div>
                @guest
                    <a href="{{ route('register') }}" class="mt-4 flex h-10 items-center justify-center rounded-lg bg-[#234e8a] text-sm font-semibold text-white hover:bg-[#193e72]">Aramıza katıl</a>
                @else
                    <a href="{{ route('posts.create') }}" class="mt-4 flex h-10 items-center justify-center rounded-lg bg-[#234e8a] text-sm font-semibold text-white hover:bg-[#193e72]">Bir şey paylaş</a>
                @endguest
            </section>

            @if($popularTags->isNotEmpty())
                <section class="border border-slate-200 bg-white p-5 sm:rounded-xl">
                    <div class="flex items-center justify-between"><h2 class="text-sm font-bold">Gündemdeki etiketler</h2><span class="text-xs text-slate-400">#</span></div>
                    <div class="mt-4 space-y-1">
                        @foreach($popularTags as $tag)
                            <a href="{{ route('home', ['q' => $tag->name]) }}" class="flex items-center justify-between rounded-lg px-2 py-2 hover:bg-slate-50">
                                <span class="text-sm font-medium text-slate-700">#{{ $tag->name }}</span>
                                <span class="text-xs text-slate-400">{{ $tag->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="px-1 text-xs leading-6 text-slate-400">
                <div class="flex flex-wrap gap-x-3 gap-y-1"><a href="#" class="hover:text-slate-600">Hakkında</a><a href="#" class="hover:text-slate-600">Kurallar</a><a href="#" class="hover:text-slate-600">Gizlilik</a></div>
                <p class="mt-2">© {{ date('Y') }} Kök Tengri</p>
            </section>
        </aside>
    </div>
</main>
</body>
</html>

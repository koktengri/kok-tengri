<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Kök Tengri — Türk kültürü, tarih, düşünce ve topluluk için ortak buluşma noktası.">
    <title>{{ config('app.name', 'Kök Tengri') }} — Birlikte konuşalım</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root{color-scheme:light;--ink:#172033;--muted:#697386;--line:#e7eaf0;--blue:#2457d6;--pale:#f5f7fb}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;background:#fff;color:var(--ink);font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;font-size:14px;line-height:1.5}
        a{color:inherit;text-decoration:none}button,input{font:inherit}.shell{width:min(1240px,calc(100% - 40px));margin:auto}
        .topbar{height:72px;border-bottom:1px solid var(--line);background:rgba(255,255,255,.96);position:sticky;top:0;z-index:20}
        .topbar-inner{height:100%;display:flex;align-items:center;gap:28px}.brand{display:flex;align-items:center;gap:11px;min-width:205px;font-weight:800;font-size:19px;letter-spacing:-.5px}
        .brand-mark{width:38px;height:38px;border-radius:12px;background:#173b8e;color:white;display:grid;place-items:center;font-weight:900;font-size:18px}
        .search{display:flex;align-items:center;gap:10px;background:#f5f7fa;border:1px solid #edf0f4;border-radius:10px;padding:0 13px;height:40px;max-width:440px;flex:1;color:#7b8494}
        .search input{background:transparent;border:0;outline:0;width:100%;color:var(--ink)}.nav{display:flex;align-items:center;gap:20px;color:#596273;font-weight:600}.nav a:hover,.side-link:hover{color:var(--blue)}
        .actions{margin-left:auto;display:flex;gap:10px;align-items:center}.btn{display:inline-flex;justify-content:center;align-items:center;gap:8px;padding:10px 15px;border-radius:9px;border:1px solid var(--line);font-weight:700;white-space:nowrap;background:#fff;cursor:pointer}.btn-primary{background:var(--blue);border-color:var(--blue);color:white}.btn-primary:hover{background:#1947ba}.btn-quiet:hover{background:#f7f8fb}
        .layout{display:grid;grid-template-columns:205px minmax(0,1fr) 260px;gap:26px;padding-top:28px;padding-bottom:60px}.sidebar{align-self:start;position:sticky;top:96px}.side-title{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:#929aaa;margin:19px 10px 9px}
        .side-link{display:flex;align-items:center;gap:11px;padding:10px;border-radius:9px;color:#596273;font-weight:600}.side-link.active{background:#eef3ff;color:#214fc1}.side-icon{width:20px;text-align:center;font-size:16px}
        .hero{border:1px solid #e5eaf3;border-radius:16px;background:linear-gradient(120deg,#f6f8ff 0%,#fff 72%);padding:29px 30px;margin-bottom:24px}
        .eyebrow{display:inline-flex;align-items:center;gap:8px;color:#2457d6;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1.2px}.eyebrow:before{content:"";width:18px;height:2px;background:#2457d6}
        h1{font-size:clamp(27px,3vw,38px);line-height:1.15;letter-spacing:-1.3px;margin:13px 0 12px;max-width:600px}.hero p{color:#626d80;max-width:570px;margin:0 0 21px;font-size:15px}.hero-actions{display:flex;gap:10px;flex-wrap:wrap}
        .section-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin:26px 0 13px}.section-head h2{font-size:17px;letter-spacing:-.3px;margin:0}.subtle-link{font-weight:700;color:var(--blue);font-size:12px}
        .chips{display:flex;gap:8px;overflow:auto;padding-bottom:5px}.chip{padding:8px 12px;border:1px solid var(--line);border-radius:8px;color:#596273;font-weight:650;white-space:nowrap}.chip.active{border-color:#cbd8ff;background:#f1f5ff;color:#244fc0}
        .post{padding:19px 0;border-bottom:1px solid var(--line)}.post-top{display:flex;align-items:center;gap:10px;color:#7b8494;font-size:12px}.avatar{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;background:#e9efff;color:#244fc0;font-weight:800;flex-shrink:0}.avatar.gold{background:#f7edda;color:#8b641a}.avatar.green{background:#e4f4eb;color:#26754b}
        .author{font-weight:750;color:#273247}.dot{width:3px;height:3px;background:#aeb5c1;border-radius:50%}.post h3{font-size:18px;line-height:1.35;letter-spacing:-.35px;margin:12px 0 7px}.post h3 a:hover{color:var(--blue)}.post p{color:#626d80;line-height:1.7;margin:0 0 13px}.tags{display:flex;gap:7px;flex-wrap:wrap}.tag{font-size:11px;color:#667085;background:#f4f6f9;padding:4px 8px;border-radius:5px}.post-footer{display:flex;align-items:center;gap:17px;color:#7b8494;font-size:12px;margin-top:15px}.post-footer span{display:inline-flex;align-items:center;gap:6px}
        .card{border:1px solid var(--line);border-radius:12px;padding:17px;margin-bottom:15px}.card h3{font-size:14px;margin:0 0 13px}.trend{display:flex;gap:10px;padding:11px 0;border-top:1px solid #f0f1f4}.trend:first-of-type{border-top:0;padding-top:0}.trend-num{font-size:12px;color:#9aa2b1;font-weight:800;width:18px}.trend strong{display:block;font-size:12px;line-height:1.45}.trend small{display:block;color:#8b93a2;margin-top:4px;font-size:11px}
        .topic{display:flex;align-items:center;gap:9px;padding:9px 0;color:#596273;font-weight:650}.topic-color{width:8px;height:8px;border-radius:3px;background:#3d66d8}.topic:nth-of-type(3) .topic-color{background:#bd8b2b}.topic:nth-of-type(4) .topic-color{background:#378765}.topic:nth-of-type(5) .topic-color{background:#9a65c7}
        .join-card{background:#f6f8fc;border-color:#e9edf5}.join-card p{color:#687386;font-size:12px;line-height:1.7;margin:0 0 13px}.join-card .btn{width:100%}
        .footer{border-top:1px solid var(--line);padding:22px 0;color:#8a93a3;font-size:12px}.mobile-menu{display:none}
        @media(max-width:1050px){.layout{grid-template-columns:175px minmax(0,1fr);gap:22px}.rightbar{display:none}.brand{min-width:auto}.nav{gap:12px}}
        @media(max-width:720px){.shell{width:min(100% - 28px,600px)}.topbar{height:62px}.topbar-inner{gap:12px}.brand{font-size:17px}.brand-mark{width:34px;height:34px}.nav,.search{display:none}.actions .btn{padding:8px 10px;font-size:12px}.mobile-menu{display:inline-flex}.layout{display:block;padding-top:18px}.sidebar{display:none}.hero{padding:23px 20px}.hero p{font-size:14px}.section-head{margin-top:22px}.post{padding:17px 0}.post h3{font-size:17px}.footer .shell{display:block}}
    </style>
</head>
<body>
<header class="topbar">
    <div class="shell topbar-inner">
        <a href="{{ url('/') }}" class="brand" aria-label="Kök Tengri ana sayfa"><span class="brand-mark">K</span><span>Kök Tengri</span></a>
        <form class="search" action="{{ url('/') }}" method="GET" role="search">
            <span aria-hidden="true">⌕</span><input name="q" value="{{ request('q') }}" placeholder="Toplulukta ara..." aria-label="Toplulukta ara">
            <span style="font-size:11px;border:1px solid #dce1e9;border-radius:4px;padding:2px 5px">/</span>
        </form>
        <nav class="nav" aria-label="Ana menü"><a href="#kesfet">Keşfet</a><a href="#konular">Konular</a><a href="#topluluk">Topluluk</a></nav>
        <div class="actions">
            <a class="btn btn-quiet" href="{{ url('/cp') }}">Giriş yap</a>
            <a class="btn btn-primary" href="{{ url('/cp/register') }}">Katıl</a>
        </div>
    </div>
</header>
<main class="shell layout">
    <aside class="sidebar" aria-label="Yan menü">
        <div class="side-title">Menü</div>
        <a class="side-link active" href="#kesfet"><span class="side-icon">⌂</span>Akış</a>
        <a class="side-link" href="#konular"><span class="side-icon">▦</span>Konuları keşfet</a>
        <a class="side-link" href="#trendler"><span class="side-icon">↗</span>Gündem</a>
        <a class="side-link" href="#topluluk"><span class="side-icon">♧</span>Üyeler</a>
        <div class="side-title">İlgi alanları</div>
        <a class="side-link" href="#konular"><span class="side-icon">◈</span>Türk tarihi</a>
        <a class="side-link" href="#konular"><span class="side-icon">⌘</span>Kültür ve sanat</a>
        <a class="side-link" href="#konular"><span class="side-icon">✳</span>Fikir ve düşünce</a>
        <a class="side-link" href="#konular"><span class="side-icon">⌁</span>Teknoloji</a>
        <a class="side-link" href="#konular"><span class="side-icon">◎</span>Gündelik yaşam</a>
    </aside>

    <section id="kesfet">
        <div class="hero">
            <span class="eyebrow">Fikirlerin buluşma noktası</span>
            <h1>Köklerimizden güç alır,<br>geleceği birlikte konuşuruz.</h1>
            <p>Tarih, kültür, düşünce ve güncel meseleler üzerine saygılı tartışmaların ve yeni fikirlerin buluştuğu topluluğa katıl.</p>
            <div class="hero-actions"><a class="btn btn-primary" href="{{ url('/cp/register') }}">Topluluğa katıl <span aria-hidden="true">→</span></a><a class="btn btn-quiet" href="#konular">Konuları keşfet</a></div>
        </div>

        <div class="section-head"><h2>İlgi alanlarını keşfet</h2><a class="subtle-link" href="#konular">Tüm konular →</a></div>
        <div class="chips" id="konular"><a class="chip active" href="#kesfet">Tümü</a><a class="chip" href="#turk-tarihi">Türk tarihi</a><a class="chip" href="#kultur">Kültür</a><a class="chip" href="#dusunce">Fikir ve düşünce</a><a class="chip" href="#teknoloji">Teknoloji</a></div>

        <div class="section-head"><h2>Topluluktan seçmeler</h2><a class="subtle-link" href="{{ url('/cp') }}">Yönetim paneli →</a></div>
        <article class="post" id="turk-tarihi">
            <div class="post-top"><span class="avatar">KT</span><span><span class="author">Kök Tengri editörleri</span><br><span>Topluluk rehberi</span></span><span class="dot"></span><span>4 dk okuma</span></div>
            <h3><a href="#topluluk">Kök Tengri'de nasıl bir topluluk oluşturuyoruz?</a></h3>
            <p>Tarihimize ve kültürümüze ilgi duyan insanların bilgi paylaşabildiği, kaynak gösterebildiği ve farklı görüşleri saygıyla tartışabildiği bir alan oluşturmak istiyoruz.</p>
            <div class="tags"><span class="tag">Topluluk</span><span class="tag">Başlangıç</span></div>
            <div class="post-footer"><span>♡ 24 beğeni</span><span>▱ 8 yorum</span><span>◷ 4 dk</span></div>
        </article>
        <article class="post" id="kultur">
            <div class="post-top"><span class="avatar gold">TT</span><span><span class="author">Tarih ve toplum</span><br><span>Öne çıkan konu</span></span><span class="dot"></span><span>6 dk okuma</span></div>
            <h3><a href="#topluluk">Tarih araştırmalarında kaynak okumanın önemi</a></h3>
            <p>Bir tarihî iddiayı değerlendirirken birincil kaynaklar, farklı araştırmacıların yorumları ve dönemin koşulları birlikte ele alınmalı. Sağlam tartışma, sağlam kaynakla başlar.</p>
            <div class="tags"><span class="tag">Türk tarihi</span><span class="tag">Araştırma</span></div>
            <div class="post-footer"><span>♡ 18 beğeni</span><span>▱ 5 yorum</span><span>◷ 6 dk</span></div>
        </article>
        <article class="post" id="dusunce">
            <div class="post-top"><span class="avatar green">FD</span><span><span class="author">Fikir defteri</span><br><span>Tartışma başlığı</span></span><span class="dot"></span><span>3 dk okuma</span></div>
            <h3><a href="#topluluk">Dijital çağda kültürel mirası nasıl aktarabiliriz?</a></h3>
            <p>Arşivler, dijital yayınlar ve topluluk katkıları kültürel hafızanın korunmasına yardımcı olabilir. Peki sizce ilk adım nereden başlamalı?</p>
            <div class="tags"><span class="tag">Kültür</span><span class="tag">Dijital dünya</span></div>
            <div class="post-footer"><span>♡ 12 beğeni</span><span>▱ 11 yorum</span><span>◷ 3 dk</span></div>
        </article>
        <p style="font-size:11px;color:#9aa2b1;margin-top:18px">Not: Bu içerikler tasarım örneğidir; henüz veritabanından gelen gerçek gönderiler değildir.</p>
    </section>

    <aside class="rightbar">
        <div class="card" id="trendler"><h3>Gündemdeki konular</h3>
            <a class="trend" href="#turk-tarihi"><span class="trend-num">01</span><span><strong>Türk tarihi ve kaynaklar</strong><small>12 tartışma · Tarih</small></span></a>
            <a class="trend" href="#kultur"><span class="trend-num">02</span><span><strong>Kültürel mirasın korunması</strong><small>8 tartışma · Kültür</small></span></a>
            <a class="trend" href="#dusunce"><span class="trend-num">03</span><span><strong>Teknoloji ve toplum</strong><small>6 tartışma · Gündem</small></span></a>
        </div>
        <div class="card"><h3>Konular</h3>
            <a class="topic" href="#turk-tarihi"><span class="topic-color"></span>Türk tarihi</a>
            <a class="topic" href="#kultur"><span class="topic-color"></span>Kültür ve sanat</a>
            <a class="topic" href="#dusunce"><span class="topic-color"></span>Fikir ve düşünce</a>
            <a class="topic" href="#teknoloji"><span class="topic-color"></span>Bilim ve teknoloji</a>
            <a class="topic" href="#topluluk"><span class="topic-color"></span>Topluluk duyuruları</a>
        </div>
        <div class="card join-card" id="topluluk"><h3>Aramıza katıl</h3><p>İlgi alanlarını paylaş, tartışmalara katıl ve topluluğun bir parçası ol.</p><a class="btn btn-primary" href="{{ url('/cp/register') }}">Üyelik oluştur</a></div>
        <div style="font-size:11px;color:#929aaa;line-height:2;padding:0 4px"><a href="#topluluk">Topluluk kuralları</a> · <a href="#topluluk">Gizlilik</a> · <a href="#topluluk">Hakkımızda</a><br>© {{ date('Y') }} Kök Tengri</div>
    </aside>
</main>
<footer class="footer"><div class="shell">Kök Tengri <span style="float:right">Bilgi paylaşımı · Saygılı tartışma · Ortak kültür</span></div></footer>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AI Content Repurposing Tool')</title>
    <meta name="description" content="@yield('meta_description', 'AI content repurposing tool that turns webinars, blogs, and podcasts into multi-channel assets, calendars, and SEO-ready drafts in minutes.')">
    <meta name="author" content="Imran Ahmed <me@imrandev.bd>">
    <meta name="theme-color" content="#C026D3">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700&family=IBM+Plex+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --accent: {{ $accent ?? '#C026D3' }}; --ink:#1a0b22; --muted:#6b4578; --bg:#fdf4ff; }
        * { box-sizing: border-box; }
        body { margin:0; font-family:'IBM Plex Sans',sans-serif; color:var(--ink); background:
            radial-gradient(900px 420px at 12% -8%, color-mix(in srgb, var(--accent) 28%, white), transparent),
            radial-gradient(700px 380px at 100% 0%, color-mix(in srgb, var(--accent) 16%, #fff), transparent),
            linear-gradient(180deg, #fae8ff 0%, var(--bg) 42%, #fff 100%); }
        a { color: var(--accent); text-decoration: none; }
        .wrap { width: min(1120px, 92%); margin: 0 auto; }
        header { display:flex; justify-content:space-between; align-items:center; padding:1.25rem 0; }
        .brand { font-family:'Sora',sans-serif; font-size:1.55rem; font-weight:700; color:var(--accent); letter-spacing:-.02em; }
        nav { display:flex; gap:1rem; flex-wrap:wrap; align-items:center; }
        nav a { color:var(--muted); font-weight:600; }
        .btn { display:inline-block; background:var(--accent); color:#fff !important; padding:.75rem 1.15rem; border-radius:.55rem; font-weight:700; }
        .btn.ghost { background:transparent; color:var(--accent) !important; border:1px solid color-mix(in srgb, var(--accent) 45%, white); }
        .hero { padding: 3.5rem 0 2.5rem; display:grid; gap:1rem; max-width: 46rem; }
        .hero h1 { font-family:'Sora',sans-serif; font-size: clamp(2.2rem, 5vw, 3.4rem); line-height:1.05; margin:0; color:var(--accent); letter-spacing:-.03em; }
        .hero p { font-size:1.125rem; color:var(--muted); margin:0; }
        .cta { display:flex; gap:.75rem; flex-wrap:wrap; margin-top:.75rem; }
        .grid { display:grid; grid-template-columns: repeat(auto-fit,minmax(240px,1fr)); gap:1rem; padding: 1.5rem 0 3rem; }
        .card { background: rgba(255,255,255,.88); border:1px solid #f0c4f8; border-radius:.85rem; padding:1.25rem; }
        .card h3 { margin:.2rem 0 .5rem; font-size:1.1rem; font-family:'Sora',sans-serif; }
        .card p { margin:0; color:var(--muted); }
        .badge { display:inline-block; font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.04em; color:var(--accent); }
        footer { border-top:1px solid #f0c4f8; padding:2rem 0; color:var(--muted); font-size:.95rem; }
        .section-title { font-family:'Sora',sans-serif; font-size:2rem; color:var(--accent); margin:2rem 0 .5rem; }
        table { width:100%; border-collapse:collapse; margin:1rem 0 2rem; }
        th, td { text-align:left; padding:.7rem .5rem; border-bottom:1px solid #f0c4f8; }
        @media (max-width:720px){ header{flex-direction:column; align-items:flex-start; gap:1rem;} }
    </style>
</head>
<body>
<div class="wrap">
    <header>
        <a class="brand" href="{{ route('home') }}">ContentForge</a>
        <nav>
            <a href="{{ route('features') }}">Features</a>
            <a href="{{ route('modules') }}">Modules</a>
            <a href="{{ route('pricing') }}">Pricing</a>
            <a href="{{ route('security') }}">Security</a>
            <a href="{{ route('demo') }}">Demo</a>
            <a class="btn" href="/admin">Admin Login</a>
        </nav>
    </header>
    @yield('content')
    <footer>
        <p><strong>AI Content Repurposing Tool</strong> — built by <a href="https://imrandev.bd">Imran Ahmed</a> · <a href="mailto:me@imrandev.bd">me@imrandev.bd</a></p>
        <p>Toggleable modules for ingest, AI repurposing, calendars, SEO drafts, brand voice, and channels.</p>
    </footer>
</div>
</body>
</html>

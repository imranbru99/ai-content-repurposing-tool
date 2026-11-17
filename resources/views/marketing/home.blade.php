@extends('layouts.marketing')

@section('title', 'AI Content Repurposing Tool — Webinars to Multi-Channel Assets')
@section('meta_description', 'AI content repurposing tool that turns webinars, blogs, and podcasts into multi-channel assets, calendars, and SEO-ready drafts in minutes.')

@section('content')
<section class="hero">
    <span class="badge">Content operations platform</span>
    <h1>ContentForge</h1>
    <p>Turn webinars, blogs, and podcasts into multi-channel assets, publish calendars, and SEO-ready drafts in minutes — with every module toggleable for your content ops stack.</p>
    <div class="cta">
        <a class="btn" href="/admin">Open Admin</a>
        <a class="btn ghost" href="{{ route('demo') }}">View Demo Access</a>
    </div>
</section>
<section class="grid">
    @foreach($modules as $module)
        <article class="card">
            <span class="badge">{{ ($module['enabled'] ?? false) ? 'Enabled' : 'Optional' }}</span>
            <h3>{{ $module['name'] ?? $module['key'] }}</h3>
            <p>{{ $module['description'] ?? '' }}</p>
        </article>
    @endforeach
</section>
@endsection

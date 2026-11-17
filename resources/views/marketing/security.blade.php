@extends('layouts.marketing')
@section('title', 'Security — AI Content Repurposing Tool')
@section('meta_description', 'Role-based access, module isolation, and operational controls for content teams.')
@section('content')
<h2 class="section-title">Security posture</h2>
<section class="grid">
    <article class="card"><h3>Multi-role access</h3><p>Super Admin, Admin, Manager, Staff, Client, and Demo with Filament panel gating.</p></article>
    <article class="card"><h3>Module isolation</h3><p>Disabled modules hide UI and throw on service entry — no silent side effects.</p></article>
    <article class="card"><h3>Audit-friendly IDs</h3><p>Source, asset, SEO, and calendar numbers make reviews and handoffs traceable.</p></article>
    <article class="card"><h3>Docker-ready</h3><p>Compose stack with MySQL for reproducible demos and staging.</p></article>
</section>
@endsection

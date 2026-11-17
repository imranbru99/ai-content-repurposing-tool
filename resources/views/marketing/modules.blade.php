@extends('layouts.marketing')
@section('title', 'Modules — AI Content Repurposing Tool')
@section('meta_description', 'Toggle ingest, repurpose AI, calendars, SEO drafts, brand voice, and channels on or off for your content business.')
@section('content')
<h2 class="section-title">Modules on / off</h2>
<p>Every domain can be enabled or disabled from config and the Filament Modules resource. Disabled modules hide from navigation and refuse service calls.</p>
<table>
    <thead><tr><th>Module</th><th>Status</th><th>Purpose</th></tr></thead>
    <tbody>
    @foreach($modules as $module)
        <tr>
            <td>{{ $module['name'] ?? $module['key'] }}</td>
            <td>{{ ($module['enabled'] ?? false) ? 'ON' : 'OFF' }}</td>
            <td>{{ $module['description'] ?? '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection

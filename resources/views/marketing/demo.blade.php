@extends('layouts.marketing')
@section('title', 'Demo Access — AI Content Repurposing Tool')
@section('meta_description', 'Demo users for AI Content Repurposing Tool admin and client roles.')
@section('content')
<h2 class="section-title">Demo access</h2>
<p>Password for all seeded users: <strong>password</strong></p>
<table>
    <thead><tr><th>Role</th><th>Email</th></tr></thead>
    <tbody>
        <tr><td>Demo</td><td>demo@repurposeai.test</td></tr>
        <tr><td>Super Admin</td><td>superadmin@repurposeai.test</td></tr>
        <tr><td>Admin</td><td>admin@repurposeai.test</td></tr>
        <tr><td>Manager</td><td>manager@repurposeai.test</td></tr>
        <tr><td>Staff</td><td>staff@repurposeai.test</td></tr>
        <tr><td>Client</td><td>client@repurposeai.test</td></tr>
    </tbody>
</table>
<p><a class="btn" href="/admin">Open Filament Admin</a></p>
@endsection

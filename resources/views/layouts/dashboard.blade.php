{{-- Admin memakai layouts.admin, customer memakai layouts.customer --}}
@extends(auth()->check() && auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.customer')
{{--
    Dispatcher layout: dipakai oleh semua halaman setelah login.
    Admin  -> layouts.admin    (sidebar, tema coklat)
    Customer -> layouts.customer (navbar atas, tema coklat yang sama)
--}}
@if (auth()->user()->isAdmin())
    @include('layouts.admin')
@else
    @include('layouts.customer')
@endif
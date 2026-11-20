@extends('layouts.dashboard')

@push('styles')
<style>
    .cu-wrap { 
      max-width: 1280px; 
      margin: 0 auto; 
    }
    .cu-head { 
      display: flex; 
      justify-content: space-between; 
      align-items: flex-end; 
      gap: 1rem; 
      flex-wrap: wrap; 
      margin-bottom: 1.3rem;
    }
    .cu-head h3 { 
      margin: 0 0 .2rem; 
      font-weight: 800; 
      color: #4A3B32; 
      display: flex; 
      align-items: center; 
      gap: .6rem; 
    }
    .cu-head h3 i { 
     color: #8B6F5B; 
    }
    .cu-head p { 
      margin: 0; 
      color: #85766B; 
    }
    .cu-total { 
      display: flex; 
      align-items: center; 
      gap: .9rem; 
      background: linear-gradient(135deg, #8B6F5B, #5E4334); 
      color: #fff; 
      border-radius: 18px; 
      padding: .8rem 1.4rem; 
      box-shadow: 0 10px 22px rgba(94, 67, 52, .28); 
    }
    .cu-total i {
      font-size: 1.7rem; 
      color: #F1D9B8; 
    }
    .cu-total strong { 
      display: block; 
      font-size: 1.7rem; 
      line-height: 1.1; 
    }
    .cu-total small { 
      color: #F1D9B8; 
      font-weight: 700; 
    }

    .cu-bar { 
      display: flex; 
      gap: .8rem; 
      align-items: center; 
      flex-wrap: wrap; 
      background: #fff; 
      border-radius: 16px; 
      box-shadow: 0 2px 12px rgba(74, 59, 50, .07); 
      padding: .8rem 1rem; 
      margin-bottom: 1.1rem; 
    }
    .cu-search { 
      position: relative; 
      flex: 1; 
      min-width: 220px; 
      max-width: 420px; 
    }
    .cu-search i { 
      position: absolute; 
      left: .95rem; 
      top: 50%; 
      transform: translateY(-50%); 
      color: #C9AF9A; 
    }
    .cu-search input {
      width: 100%; 
      border: 1.5px solid #EFE3D3; 
      border-radius: 12px; 
      padding: .62rem 1rem .62rem 2.5rem; 
      background: #FDFAF6; 
    }
    .cu-search input:focus { 
      outline: none; 
      border-color: #8B6F5B; 
      background: #fff; 
      box-shadow: 0 0 0 .2rem rgba(139, 111, 91, .15); 
    }
    .cu-btn { 
      border: 0; 
      background: #8B6F5B; 
      color: #fff; 
      font-weight: 800; 
      padding: .62rem 1.3rem; 
      border-radius: 12px; 
    }
    .cu-btn:hover { 
      background: #5E4334; 
    }
    .cu-reset { 
      color: #8B6F5B; 
      font-weight: 700; 
      text-decoration: none; 
    }
    .cu-count { 
      margin-left: auto; 
      color: #85766B; 
      font-weight: 600; 
      font-size: .9rem; 
    }

    .cu-card { 
      background: #fff; 
      border: 1px solid #EFE3D3; 
      border-radius: 20px; 
      box-shadow: 0 2px 14px rgba(74, 59, 50, .07); 
      overflow: hidden; 
    }
    .cu-table {
      width: 100%; 
      border-collapse: collapse; 
    }
    .cu-table th { 
      background: #EDDECA; 
      color: #4A3B32; 
      font-size: .8rem; 
      font-weight: 800; 
      letter-spacing: .06em; 
      text-transform: uppercase; 
      padding: .9rem 1.1rem; 
      text-align: left; 
      white-space: nowrap; 
    }
    .cu-table td { 
      padding: .9rem 1.1rem; 
      border-bottom: 1px solid #F3E9DA; 
      vertical-align: middle; 
    }
    .cu-table tbody tr { 
      transition: background .15s; 
    }
    .cu-table tbody tr:hover { 
      background: #FDF6EA; 
    }
    .cu-table tbody tr:last-child td { 
      border-bottom: 0; 
    }
    .cu-no { 
      color: #9A8B80; 
      font-weight: 700; 
      width: 50px; 
    }
    .cu-user { 
      display: flex; 
      align-items: center; 
      gap: .8rem; 
    }
    .cu-ava { 
      width: 42px; 
      height: 42px; 
      border-radius: 50%; 
      background: linear-gradient(135deg, #A78468, #5E4334); 
      color: #fff; 
      font-weight: 800; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      flex-shrink: 0; 
      box-shadow: 0 4px 10px rgba(94, 67, 52, .25); 
    }
    .cu-name {
      font-weight: 800; 
      color: #4A3B32; 
    }
    .cu-new {
      display: inline-block; 
      background: #E3F4E6; 
      color: #2F7A3D; 
      font-size: .68rem; 
      font-weight: 800; 
      padding: .08rem .55rem; 
      border-radius: 999px; 
      margin-left: .4rem; 
      vertical-align: middle; 
    }
    .cu-mail, .cu-tel 
    { color: #5C4E44; 
      display: inline-flex; 
      align-items: center; 
      gap: .45rem; 
      text-decoration: none; 
    }
    .cu-mail i, .cu-tel i 
    { color: #B59A85; }
    a.cu-tel:hover { 
     color: #2F7A3D; 
    } a.cu-tel:hover i { color: #25A244; }
    .cu-date { 
      color: #6B5B50; 
      white-space: nowrap; 
    }
    .cu-detail { 
      display: inline-flex; 
      align-items: center; 
      gap: .4rem; 
      padding: .5rem 1rem; 
      border-radius: 11px; 
      background: #8B6F5B; 
      color: #fff; 
      font-weight: 800; 
      font-size: .86rem;
      text-decoration: none; 
      transition: background .2s, transform .2s; 
      white-space: nowrap; 
    }
    .cu-detail:hover { 
      background: #5E4334; 
      color: #fff; 
      transform: translateY(-1px); 
    }

    .cu-empty { 
      text-align: center; 
      padding: 3rem 1rem; 
      color: #85766B; 
    }
    .cu-empty i { 
      font-size: 2.8rem; 
      color: #C9AF9A; 
      display: block; 
      margin-bottom: .4rem;
    }
</style>
@endpush

@section('content')
@php
    $isPaginated = $customers instanceof \Illuminate\Pagination\AbstractPaginator;
    $rows = $isPaginated ? $customers : collect($customers);
    $total = $isPaginated ? $customers->total() : $rows->count();
    $first = $isPaginated ? $customers->firstItem() : 1;
    $q = request('search');
@endphp

<div class="cu-wrap">
    <div class="cu-head">
        <div>
            <h3><i class="bi bi-people-fill"></i>Data Pelanggan</h3>
            <p>Kelola data pelanggan yang menggunakan layanan ilustrasi.</p>
        </div>
        <div class="cu-total"><i class="bi bi-people"></i><div><strong>{{ $total }}</strong><small>Total Pelanggan</small></div></div>
    </div>

    <form method="GET" class="cu-bar">
        <div class="cu-search">
            <i class="bi bi-search"></i>
            <input type="text" name="search" value="{{ $q }}" placeholder="Cari nama atau email...">
        </div>
        <button type="submit" class="cu-btn">Cari</button>
        @if ($q)<a href="{{ route('customers.index') }}" class="cu-reset"><i class="bi bi-x-circle"></i> Reset</a>@endif
        <div class="cu-count">{{ $q ? $total . ' hasil untuk "' . $q . '"' : $total . ' pelanggan' }}</div>
    </form>

    <div class="cu-card">
        <div class="table-responsive">
            <table class="cu-table">
                <thead>
                    <tr><th>No</th><th>Pelanggan</th><th>Email</th><th>No. Telepon</th><th>Terdaftar</th><th style="text-align:right;">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($rows as $customer)
                        @php
                            $phone = $customer->phone ?? $customer->no_telepon ?? $customer->telepon ?? null;
                            $wa = $phone ? preg_replace('/^0/', '62', preg_replace('/\D/', '', $phone)) : null;
                            $isNew = $customer->created_at && $customer->created_at->gt(now()->subDays(7));
                        @endphp
                        <tr>
                            <td class="cu-no">{{ $first + $loop->index }}</td>
                            <td>
                                <div class="cu-user">
                                    <span class="cu-ava">{{ strtoupper(mb_substr($customer->name, 0, 1)) }}</span>
                                    <span class="cu-name">{{ $customer->name }}@if ($isNew)<span class="cu-new">Baru</span>@endif</span>
                                </div>
                            </td>
                            <td><span class="cu-mail"><i class="bi bi-envelope"></i>{{ $customer->email }}</span></td>
                            <td>
                                @if ($phone)
                                    <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="cu-tel" title="Chat via WhatsApp"><i class="bi bi-whatsapp"></i>{{ $phone }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="cu-date">{{ $customer->created_at?->timezone('Asia/Jakarta')->format('d M Y') }}</td>
                            <td style="text-align:right;">
                                <a href="{{ route('customers.show', $customer) }}" class="cu-detail"><i class="bi bi-eye"></i>Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="cu-empty"><i class="bi bi-person-x"></i>{{ $q ? 'Pelanggan tidak ditemukan.' : 'Belum ada pelanggan.' }}</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($isPaginated)
        <div class="mt-4">{{ $customers->withQueryString()->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Halaman laporan penjualan (grafik + rekap).
     */
    public function index(Request $request): View
    {
        return view('admin.reports.index', $this->build($request));
    }

    public function pdf(Request $request)
    {
        $data = $this->build($request);
        $filename = 'laporan-penjualan-'.$data['from']->format('Ymd').'-'.$data['to']->format('Ymd').'.pdf';

        if (class_exists(Pdf::class)) {
            return Pdf::loadView('admin.reports.pdf', $data + ['printMode' => false])
                ->setPaper('a4', 'portrait')
                ->download($filename);
        }

        return view('admin.reports.pdf', $data + ['printMode' => true]);
    }

    private function build(Request $request): array
    {
        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $from = $request->filled('from') ? Carbon::parse($request->input('from'))->startOfDay() : now()->startOfMonth();
        $to = $request->filled('to') ? Carbon::parse($request->input('to'))->endOfDay() : now()->endOfDay();

        $completed = Order::with(['user', 'servicePrice'])
            ->where('status', 'completed')
            ->whereBetween('updated_at', [$from, $to])
            ->get();

        $created = Order::with(['user', 'servicePrice'])
            ->whereBetween('created_at', [$from, $to])
            ->latest()
            ->get();

        $active = $created->where('status', '!=', 'cancelled');

        $byMonth = $from->diffInDays($to) > 62;
        $format = $byMonth ? 'Y-m' : 'Y-m-d';

        $periods = [];
        $cursor = $byMonth ? $from->copy()->startOfMonth() : $from->copy()->startOfDay();
        while ($cursor <= $to) {
            $periods[$cursor->format($format)] = [
                'label' => $cursor->copy()->locale('id')->translatedFormat($byMonth ? 'M Y' : 'd M'),
                'revenue' => 0,
                'orders' => 0,
            ];
            $byMonth ? $cursor->addMonthNoOverflow() : $cursor->addDay();
        }

        foreach ($completed as $order) {
            $key = $order->updated_at->format($format);
            if (isset($periods[$key])) {
                $periods[$key]['revenue'] += (float) $order->total_price;
            }
        }
        foreach ($active as $order) {
            $key = $order->created_at->format($format);
            if (isset($periods[$key])) {
                $periods[$key]['orders']++;
            }
        }

        $revenue = (float) $completed->sum('total_price');
        $doneCount = $completed->count();

        $topServices = $completed
            ->groupBy('service_price_id')
            ->map(fn ($rows) => [
                'name' => $rows->first()->servicePrice?->name ?? 'Layanan dihapus',
                'count' => $rows->count(),
                'revenue' => (float) $rows->sum('total_price'),
            ])
            ->sortByDesc('revenue')
            ->values();

        $statusCounts = $created->groupBy('status')->map->count();

        return [
            'from' => $from,
            'to' => $to,
            'byMonth' => $byMonth,
            'periods' => array_values($periods),
            'revenue' => $revenue,
            'ordersCount' => $active->count(),
            'doneCount' => $doneCount,
            'cancelledCount' => $created->where('status', 'cancelled')->count(),
            'average' => $doneCount > 0 ? $revenue / $doneCount : 0,
            'topServices' => $topServices,
            'statusCounts' => $statusCounts,
            'orders' => $created,
            'sales' => $completed,
        ];
    }
}

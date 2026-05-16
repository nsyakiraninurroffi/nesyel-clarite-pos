<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Ringkasan Hari Ini
        $totalSalesToday = Transaksi::whereDate('tanggal', $today)->sum('total');
        $totalTransactionsToday = Transaksi::whereDate('tanggal', $today)->count();
        $totalItemsSoldToday = DetailTransaksi::whereHas('transaksi', function($query) use ($today) {
            $query->whereDate('tanggal', $today);
        })->sum('jumlah');
        $lowStockItems = Barang::where('stok', '<=', 5)->count();

        // Data Grafik 7 Hari Terakhir
        $chartDates = collect();
        $chartSales = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates->push($date->format('d M'));
            
            $sales = Transaksi::whereDate('tanggal', $date)->sum('total');
            $chartSales->push($sales);
        }

        // Top Produk (5 Best Seller)
        $topProducts = DetailTransaksi::select('barang_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->with('barang')
            ->groupBy('barang_id')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // Data Grafik Pie (Kategori)
        $categorySales = DetailTransaksi::join('barangs', 'detail_transaksis.barang_id', '=', 'barangs.id')
            ->select('barangs.kategori', DB::raw('SUM(detail_transaksis.jumlah) as total_terjual'))
            ->groupBy('barangs.kategori')
            ->get();

        $pieLabels = $categorySales->pluck('kategori');
        $pieData = $categorySales->pluck('total_terjual');

        return view('dashboard.index', compact(
            'totalSalesToday', 
            'totalTransactionsToday', 
            'totalItemsSoldToday',
            'lowStockItems',
            'chartDates',
            'chartSales',
            'topProducts',
            'pieLabels',
            'pieData'
        ));
    }
}

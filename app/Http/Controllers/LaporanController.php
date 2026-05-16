<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', Carbon::today()->format('Y-m-d'));
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::today()->format('Y-m-d'));

        // Summary
        $totalPendapatan = Transaksi::whereDate('tanggal', '>=', $tanggalMulai)
            ->whereDate('tanggal', '<=', $tanggalAkhir)
            ->sum('total');

        $totalTransaksi = Transaksi::whereDate('tanggal', '>=', $tanggalMulai)
            ->whereDate('tanggal', '<=', $tanggalAkhir)
            ->count();

        $totalItemTerjual = DetailTransaksi::whereHas('transaksi', function ($query) use ($tanggalMulai, $tanggalAkhir) {
            $query->whereDate('tanggal', '>=', $tanggalMulai)
                  ->whereDate('tanggal', '<=', $tanggalAkhir);
        })->sum('jumlah');

        // Pendapatan per hari (untuk chart)
        $dailyRevenue = Transaksi::whereDate('tanggal', '>=', $tanggalMulai)
            ->whereDate('tanggal', '<=', $tanggalAkhir)
            ->select(DB::raw('DATE(tanggal) as date'), DB::raw('SUM(total) as revenue'), DB::raw('COUNT(*) as trx_count'))
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('date', 'asc')
            ->get();

        // Detail transaksi
        $transaksis = Transaksi::with(['detailTransaksis.barang'])
            ->whereDate('tanggal', '>=', $tanggalMulai)
            ->whereDate('tanggal', '<=', $tanggalAkhir)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Rata-rata per hari
        $jumlahHari = max(1, Carbon::parse($tanggalMulai)->diffInDays(Carbon::parse($tanggalAkhir)) + 1);
        $rataRataHarian = $totalPendapatan / $jumlahHari;

        return view('laporan.index', compact(
            'tanggalMulai',
            'tanggalAkhir',
            'totalPendapatan',
            'totalTransaksi',
            'totalItemTerjual',
            'rataRataHarian',
            'dailyRevenue',
            'transaksis'
        ));
    }

    public function exportExcel(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', Carbon::today()->format('Y-m-d'));
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::today()->format('Y-m-d'));

        $transaksis = Transaksi::with(['detailTransaksis.barang'])
            ->whereDate('tanggal', '>=', $tanggalMulai)
            ->whereDate('tanggal', '<=', $tanggalAkhir)
            ->orderBy('tanggal', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $fileName = 'Laporan_Penjualan_' . $tanggalMulai . '_sd_' . $tanggalAkhir . '.xls';

        $periodeLabel = Carbon::parse($tanggalMulai)->format('d/m/Y') . ' s/d ' . Carbon::parse($tanggalAkhir)->format('d/m/Y');

        // Build HTML table that Excel can read natively
        $html = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <!--[if gte mso 9]>
            <xml>
                <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                        <x:ExcelWorksheet>
                            <x:Name>Laporan Penjualan</x:Name>
                            <x:WorksheetOptions>
                                <x:DisplayGridlines/>
                            </x:WorksheetOptions>
                        </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                </x:ExcelWorkbook>
            </xml>
            <![endif]-->
            <style>
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #D1D5DB; padding: 8px 12px; font-family: Calibri, sans-serif; font-size: 11pt; }
                th { background-color: #8f7cc3; color: #ffffff; font-weight: bold; text-align: center; }
                .title { font-size: 16pt; font-weight: bold; color: #3f334d; text-align: center; border: none; }
                .subtitle { font-size: 11pt; font-style: italic; color: #8a7c93; text-align: center; border: none; }
                .grand-total { background-color: #F3E8F5; font-weight: bold; font-size: 11pt; }
                .number { text-align: right; }
                .center { text-align: center; }
            </style>
        </head>
        <body>
            <table>
                <tr><td class="title" colspan="8">NESYÈL CLARITÉ - LAPORAN PENJUALAN</td></tr>
                <tr><td class="subtitle" colspan="8">Periode: ' . $periodeLabel . '</td></tr>
                <tr><td colspan="8" style="border:none;"></td></tr>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Subtotal (Rp)</th>
                </tr>';

        $no = 1;
        $grandTotal = 0;

        foreach ($transaksis as $trx) {
            $invoice = 'INV-' . str_pad($trx->id, 5, '0', STR_PAD_LEFT);
            $tanggal = Carbon::parse($trx->tanggal)->format('d/m/Y');
            $jam = $trx->created_at->format('H:i');

            foreach ($trx->detailTransaksis as $detail) {
                $namaBarang = $detail->barang ? $detail->barang->nama_barang : 'Barang Dihapus';
                $hargaSatuan = $detail->barang ? $detail->barang->harga : ($detail->subtotal / max(1, $detail->jumlah));

                $html .= '<tr>
                    <td class="center">' . $no . '</td>
                    <td>' . $invoice . '</td>
                    <td class="center">' . $tanggal . '</td>
                    <td class="center">' . $jam . '</td>
                    <td>' . htmlspecialchars($namaBarang) . '</td>
                    <td class="center">' . $detail->jumlah . '</td>
                    <td class="number">' . number_format($hargaSatuan, 0, ',', '.') . '</td>
                    <td class="number">' . number_format($detail->subtotal, 0, ',', '.') . '</td>
                </tr>';
                $no++;
            }
            $grandTotal += $trx->total;
        }

        $html .= '<tr class="grand-total">
                    <td colspan="7" class="number">GRAND TOTAL</td>
                    <td class="number">' . number_format($grandTotal, 0, ',', '.') . '</td>
                </tr>';

        $html .= '</table></body></html>';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ];

        return response($html, 200, $headers);
    }
}

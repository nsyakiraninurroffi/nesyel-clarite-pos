<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $barangs = Barang::where('stok', '>', 0)->get();
        return view('transaksi.index', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:barangs,id',
            'items.*.qty' => 'required|integer|min:1',
            'total' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $transaksi = Transaksi::create([
                'tanggal' => now(),
                'total' => $request->total,
            ]);

            foreach ($request->items as $item) {
                $barang = Barang::find($item['id']);
                
                if ($barang->stok < $item['qty']) {
                    throw new \Exception('Stok tidak cukup untuk barang: ' . $barang->nama_barang);
                }

                $subtotal = $barang->harga * $item['qty'];

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $item['qty'],
                    'subtotal' => $subtotal,
                ]);

                // Kurangi stok
                $barang->decrement('stok', $item['qty']);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function history()
    {
        $transaksis = Transaksi::orderBy('created_at', 'desc')->get();
        return view('transaksi.history', compact('transaksis'));
    }

    public function historyDetail($id)
    {
        $transaksi = Transaksi::with(['detailTransaksis.barang'])->findOrFail($id);
        
        $html = '<div class="table-responsive"><table class="table table-sm text-center align-middle">';
        $html .= '<thead class="table-light"><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead><tbody>';
        
        foreach($transaksi->detailTransaksis as $dt) {
            $nama = $dt->barang ? $dt->barang->nama_barang : 'Barang Dihapus';
            $harga = $dt->barang ? $dt->barang->harga : ($dt->subtotal / $dt->jumlah);
            
            $html .= '<tr>';
            $html .= '<td class="text-start">' . $nama . '</td>';
            $html .= '<td>Rp ' . number_format($harga, 0, ',', '.') . '</td>';
            $html .= '<td>' . $dt->jumlah . '</td>';
            $html .= '<td class="fw-bold">Rp ' . number_format($dt->subtotal, 0, ',', '.') . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table></div>';
        $html .= '<div class="text-end mt-3 border-top pt-2"><h5 class="fw-bold text-dark-pink">Grand Total: Rp ' . number_format($transaksi->total, 0, ',', '.') . '</h5></div>';
        
        return response()->json(['success' => true, 'html' => $html]);
    }
}

<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SalesReportExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths, WithEvents
{
    protected $tanggalMulai;
    protected $tanggalAkhir;
    protected $rowCount = 0;

    public function __construct(string $tanggalMulai, string $tanggalAkhir)
    {
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection()
    {
        $transaksis = Transaksi::with(['detailTransaksis.barang'])
            ->whereDate('tanggal', '>=', $this->tanggalMulai)
            ->whereDate('tanggal', '<=', $this->tanggalAkhir)
            ->orderBy('tanggal', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $rows = collect();
        $no = 1;
        $grandTotal = 0;

        foreach ($transaksis as $trx) {
            $invoice = 'INV-' . str_pad($trx->id, 5, '0', STR_PAD_LEFT);
            $tanggal = Carbon::parse($trx->tanggal)->format('d/m/Y');
            $jam = $trx->created_at->format('H:i');

            foreach ($trx->detailTransaksis as $detail) {
                $namaBarang = $detail->barang ? $detail->barang->nama_barang : 'Barang Dihapus';
                $hargaSatuan = $detail->barang ? $detail->barang->harga : ($detail->subtotal / max(1, $detail->jumlah));

                $rows->push([
                    'no' => $no,
                    'invoice' => $invoice,
                    'tanggal' => $tanggal,
                    'jam' => $jam,
                    'produk' => $namaBarang,
                    'qty' => $detail->jumlah,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $detail->subtotal,
                ]);
                $no++;
            }
            $grandTotal += $trx->total;
        }

        // Grand total row
        $rows->push([
            'no' => '',
            'invoice' => '',
            'tanggal' => '',
            'jam' => '',
            'produk' => '',
            'qty' => '',
            'harga_satuan' => 'GRAND TOTAL',
            'subtotal' => $grandTotal,
        ]);

        $this->rowCount = $rows->count();

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Invoice',
            'Tanggal',
            'Jam',
            'Produk',
            'Qty',
            'Harga Satuan (Rp)',
            'Subtotal (Rp)',
        ];
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 18,
            'C' => 14,
            'D' => 10,
            'E' => 30,
            'F' => 8,
            'G' => 20,
            'H' => 20,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '8f7cc3'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $this->rowCount + 1; // +1 for heading

                // Title row above data
                $sheet->insertNewRowBefore(1, 2);
                $sheet->setCellValue('A1', 'NESYÈL CLARITÉ - LAPORAN PENJUALAN');
                $sheet->setCellValue('A2', 'Periode: ' . Carbon::parse($this->tanggalMulai)->format('d/m/Y') . ' s/d ' . Carbon::parse($this->tanggalAkhir)->format('d/m/Y'));

                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '3f334d']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['size' => 11, 'italic' => true, 'color' => ['rgb' => '8a7c93']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Border all data cells
                $dataLastRow = $lastRow + 2; // offset by 2 title rows
                $sheet->getStyle('A3:H' . $dataLastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'D1D5DB'],
                        ],
                    ],
                ]);

                // Grand total row styling
                $sheet->getStyle('A' . $dataLastRow . ':H' . $dataLastRow)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F3E8F5'],
                    ],
                ]);

                // Number format for currency columns
                $sheet->getStyle('G4:H' . $dataLastRow)->getNumberFormat()
                    ->setFormatCode('#,##0');
            },
        ];
    }
}

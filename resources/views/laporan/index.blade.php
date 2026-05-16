@extends('layouts.app')

@push('styles')
<style>
    .laporan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }

    .filter-card {
        border-radius: 20px;
        box-shadow: var(--shadow-sm);
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        padding: 24px 28px;
        margin-bottom: 28px;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .summary-card {
        border-radius: 20px;
        box-shadow: var(--shadow-sm);
        transition: transform 0.25s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.25s ease;
        background: var(--card-bg);
        overflow: hidden;
        position: relative;
        border: 1px solid var(--border-color);
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .summary-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        transition: transform 0.2s ease;
    }
    .summary-card:hover .summary-icon {
        transform: scale(1.08);
    }

    .bg-pink-light { background: linear-gradient(135deg, #fdf2f8, #fce7f3); color: #c2477e; }
    .bg-peach-light { background: linear-gradient(135deg, #fff5eb, #ffedd5); color: #d97706; }
    .bg-purple-light { background: linear-gradient(135deg, #f3f0ff, #ede9fe); color: #7c3aed; }
    .bg-green-light { background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #059669; }

    .btn-export {
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff !important;
        border: none;
        border-radius: 30px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.3);
        letter-spacing: 0.5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-export:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 18px rgba(5, 150, 105, 0.45);
        color: #fff !important;
    }
    .btn-export:active {
        transform: translateY(0) scale(0.97);
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .detail-toggle {
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .detail-toggle:hover {
        background-color: var(--border-color) !important;
    }

    .trx-detail-row {
        display: none;
    }
    .trx-detail-row.show {
        display: table-row;
    }

    .filter-btn {
        background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple));
        color: #fff !important;
        border: none;
        border-radius: 30px;
        padding: 12px 32px;
        font-weight: 600;
        transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 4px 10px rgba(161, 140, 209, 0.3);
    }
    .filter-btn:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 18px rgba(161, 140, 209, 0.45);
        color: #fff !important;
    }

    .quick-filter-btn {
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        border-radius: 30px;
        padding: 6px 16px;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .quick-filter-btn:hover, .quick-filter-btn.active {
        background: var(--border-color);
        color: var(--gold-accent);
        border-color: var(--gold-accent);
    }

    @media (max-width: 768px) {
        .laporan-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="fade-in">
    {{-- Header --}}
    <div class="laporan-header">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 50px; height: 50px; margin-right: 15px; border-radius: 50%; object-fit: cover; box-shadow: var(--shadow-sm);">
            <div>
                <h3 class="fw-bold mb-0 brand-font" style="color: var(--text-color);">
                    <i class="fa-solid fa-chart-bar me-2" style="color: var(--gold-accent);"></i>Laporan Pendapatan
                </h3>
                <p class="text-muted mb-0">Analisis performa penjualan toko kamu.</p>
            </div>
        </div>
        <a href="{{ route('laporan.export', ['tanggal_mulai' => $tanggalMulai, 'tanggal_akhir' => $tanggalAkhir]) }}" class="btn-export" id="btnExport">
            <i class="fa-solid fa-file-excel"></i>
            Export Excel
        </a>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form id="filterForm" method="GET" action="{{ route('laporan.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label"><i class="fa-regular fa-calendar me-1"></i> Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai }}">
            </div>
            <div class="col-md-4">
                <label class="form-label"><i class="fa-regular fa-calendar-check me-1"></i> Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir }}">
            </div>
            <div class="col-md-4 d-flex gap-2 align-items-end">
                <button type="submit" class="filter-btn">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
            </div>
            <div class="col-12 d-flex gap-2 flex-wrap mt-2">
                <span class="text-muted small fw-semibold me-1 d-flex align-items-center">Quick:</span>
                <button type="button" class="quick-filter-btn" onclick="setQuickFilter('today')">Hari Ini</button>
                <button type="button" class="quick-filter-btn" onclick="setQuickFilter('yesterday')">Kemarin</button>
                <button type="button" class="quick-filter-btn" onclick="setQuickFilter('week')">7 Hari</button>
                <button type="button" class="quick-filter-btn" onclick="setQuickFilter('month')">30 Hari</button>
                <button type="button" class="quick-filter-btn" onclick="setQuickFilter('thisMonth')">Bulan Ini</button>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="summary-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="summary-icon bg-pink-light">
                        <i class="fa-solid fa-rupiah-sign"></i>
                    </div>
                </div>
                <p class="text-muted mb-1 fw-semibold">Total Pendapatan</p>
                <h4 class="fw-bold mb-0" style="color: var(--text-color)">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="summary-icon bg-purple-light">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                </div>
                <p class="text-muted mb-1 fw-semibold">Jumlah Transaksi</p>
                <h4 class="fw-bold mb-0" style="color: var(--text-color)">{{ $totalTransaksi }} Struk</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="summary-icon bg-peach-light">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                </div>
                <p class="text-muted mb-1 fw-semibold">Item Terjual</p>
                <h4 class="fw-bold mb-0" style="color: var(--text-color)">{{ $totalItemTerjual }} Pcs</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="summary-icon bg-green-light">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                </div>
                <p class="text-muted mb-1 fw-semibold">Rata-rata / Hari</p>
                <h4 class="fw-bold mb-0" style="color: var(--text-color)">Rp {{ number_format($rataRataHarian, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>

    {{-- Chart Pendapatan Harian --}}
    @if($dailyRevenue->count() > 1)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card summary-card p-4 border-0">
                <h5 class="fw-bold mb-4 brand-font" style="color: var(--text-color)">
                    <i class="fa-solid fa-chart-area me-2" style="color: var(--accent-purple)"></i>Grafik Pendapatan Harian
                </h5>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Tabel Detail Transaksi --}}
    <div class="row">
        <div class="col-12">
            <div class="card summary-card border-0" style="border-radius: 20px;">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-4 pb-0">
                        <h5 class="fw-bold mb-0 brand-font" style="color: var(--text-color)">
                            <i class="fa-solid fa-list-check me-2" style="color: var(--gold-accent)"></i>Rincian Transaksi
                        </h5>
                        <span class="badge rounded-pill px-3 py-2" style="background: var(--border-color); color: var(--text-muted); font-size: 0.85rem;">
                            {{ $transaksis->count() }} Transaksi
                        </span>
                    </div>
                    <div class="table-responsive p-4 pt-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: var(--nude-beige); border-bottom: 2px solid var(--accent-purple);">
                                <tr>
                                    <th class="py-3 ps-3" style="color: var(--accent-purple)">Invoice</th>
                                    <th class="py-3" style="color: var(--accent-purple)">Tanggal & Jam</th>
                                    <th class="py-3" style="color: var(--accent-purple)">Produk</th>
                                    <th class="py-3 text-center" style="color: var(--accent-purple)">Qty</th>
                                    <th class="py-3 text-end" style="color: var(--accent-purple)">Total</th>
                                    <th class="py-3 text-center pe-3" style="color: var(--accent-purple)">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $trx)
                                <tr class="detail-toggle" onclick="toggleDetail({{ $trx->id }})">
                                    <td class="ps-3 fw-bold text-muted">INV-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>
                                        <div class="fw-semibold" style="color: var(--text-color)">{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') }}</div>
                                        <div class="small text-muted">{{ $trx->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td>
                                        <span class="text-muted small">{{ $trx->detailTransaksis->count() }} produk</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill px-2 py-1" style="background: var(--border-color); color: var(--text-color);">
                                            {{ $trx->detailTransaksis->sum('jumlah') }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold" style="color: var(--accent-purple)">
                                        Rp {{ number_format($trx->total, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center pe-3">
                                        <button class="btn btn-sm px-3" style="background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple)); color: white; border-radius: 10px; font-size: 0.75rem;" onclick="event.stopPropagation(); toggleDetail({{ $trx->id }})">
                                            <i class="fa-solid fa-chevron-down detail-icon-{{ $trx->id }}" style="transition: transform 0.2s ease;"></i>
                                        </button>
                                    </td>
                                </tr>
                                {{-- Detail row --}}
                                <tr class="trx-detail-row" id="detail-{{ $trx->id }}">
                                    <td colspan="6" class="p-0 border-0">
                                        <div style="background: var(--nude-beige); padding: 16px 24px; border-radius: 0 0 12px 12px; margin: 0 12px 8px 12px;">
                                            <table class="table table-sm text-center align-middle mb-0" style="font-size: 0.85rem;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-start" style="color: var(--text-muted); border: none;">Produk</th>
                                                        <th style="color: var(--text-muted); border: none;">Harga</th>
                                                        <th style="color: var(--text-muted); border: none;">Qty</th>
                                                        <th class="text-end" style="color: var(--text-muted); border: none;">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($trx->detailTransaksis as $dt)
                                                    <tr>
                                                        <td class="text-start" style="border-color: var(--border-color);">{{ $dt->barang ? $dt->barang->nama_barang : 'Barang Dihapus' }}</td>
                                                        <td style="border-color: var(--border-color);">Rp {{ number_format($dt->barang ? $dt->barang->harga : ($dt->subtotal / $dt->jumlah), 0, ',', '.') }}</td>
                                                        <td style="border-color: var(--border-color);">{{ $dt->jumlah }}</td>
                                                        <td class="text-end fw-bold" style="border-color: var(--border-color); color: var(--accent-purple);">Rp {{ number_format($dt->subtotal, 0, ',', '.') }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fa-solid fa-file-invoice fa-3x mb-3" style="color: var(--accent-purple); opacity: 0.25;"></i>
                                        <h6 class="fw-bold brand-font" style="color: var(--text-color)">Tidak Ada Transaksi</h6>
                                        <p class="text-muted small mb-0">Tidak ditemukan transaksi pada periode yang dipilih.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Quick Filter Logic
    function setQuickFilter(type) {
        const today = new Date();
        let startDate, endDate;

        switch(type) {
            case 'today':
                startDate = endDate = formatDate(today);
                break;
            case 'yesterday':
                const yesterday = new Date(today);
                yesterday.setDate(today.getDate() - 1);
                startDate = endDate = formatDate(yesterday);
                break;
            case 'week':
                const weekAgo = new Date(today);
                weekAgo.setDate(today.getDate() - 6);
                startDate = formatDate(weekAgo);
                endDate = formatDate(today);
                break;
            case 'month':
                const monthAgo = new Date(today);
                monthAgo.setDate(today.getDate() - 29);
                startDate = formatDate(monthAgo);
                endDate = formatDate(today);
                break;
            case 'thisMonth':
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                startDate = formatDate(firstDay);
                endDate = formatDate(today);
                break;
        }

        document.querySelector('input[name="tanggal_mulai"]').value = startDate;
        document.querySelector('input[name="tanggal_akhir"]').value = endDate;
        document.getElementById('filterForm').submit();
    }

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Toggle detail row
    function toggleDetail(id) {
        const row = document.getElementById('detail-' + id);
        const icon = document.querySelector('.detail-icon-' + id);

        if (row.classList.contains('show')) {
            row.classList.remove('show');
            if (icon) icon.style.transform = 'rotate(0deg)';
        } else {
            row.classList.add('show');
            if (icon) icon.style.transform = 'rotate(180deg)';
        }
    }

    // Update export link when filter changes
    document.getElementById('filterForm').addEventListener('submit', function() {
        const mulai = document.querySelector('input[name="tanggal_mulai"]').value;
        const akhir = document.querySelector('input[name="tanggal_akhir"]').value;
        const exportBtn = document.getElementById('btnExport');
        exportBtn.href = `/laporan/export?tanggal_mulai=${mulai}&tanggal_akhir=${akhir}`;
    });

    // Revenue Chart
    @if(isset($dailyRevenue) && $dailyRevenue->count() > 1)
    const ctx = document.getElementById('revenueChart').getContext('2d');

    let gradient = ctx.createLinearGradient(0, 0, 0, 350);
    gradient.addColorStop(0, 'rgba(161, 140, 209, 0.4)');
    gradient.addColorStop(1, 'rgba(253, 242, 248, 0.05)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! $dailyRevenue->pluck('date')->map(function($d) { return \Carbon\Carbon::parse($d)->format('d M'); })->toJson() !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! $dailyRevenue->pluck('revenue')->toJson() !!},
                backgroundColor: gradient,
                borderColor: '#a18cd1',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#3f334d',
                    bodyColor: '#8f7cc3',
                    borderColor: '#f3e8f5',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(248, 200, 220, 0.15)', drawBorder: false },
                    ticks: {
                        font: { family: "'Poppins', sans-serif" },
                        callback: function(value) {
                            if(value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                            if(value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
                            return 'Rp ' + value;
                        }
                    }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { font: { family: "'Poppins', sans-serif" } }
                }
            }
        }
    });
    @endif
</script>
@endpush

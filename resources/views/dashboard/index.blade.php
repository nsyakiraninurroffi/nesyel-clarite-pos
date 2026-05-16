@extends('layouts.app')

@push('styles')
<style>
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
    .bg-red-light { background: linear-gradient(135deg, #fff0f0, #fee2e2); color: #dc2626; }

    .chart-container {
        position: relative;
        height: 350px;
        width: 100%;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 fade-in">
    <div class="d-flex align-items-center">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 50px; height: 50px; margin-right: 15px; border-radius: 50%; object-fit: cover; box-shadow: var(--shadow-sm);">
        <div>
            <h3 class="fw-bold mb-0 brand-font" style="color: var(--text-color);">👋 Halo Admin!</h3>
            <p class="text-muted mb-0">Ini ringkasan penjualan toko kamu hari ini.</p>
        </div>
    </div>
    <div class="text-end">
        <span class="badge bg-white text-dark shadow-sm px-3 py-2 fs-6 rounded-pill border">
            <i class="fa-regular fa-calendar me-2" style="color: var(--accent-pink)"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </span>
    </div>
</div>

<div class="row g-4 mb-5 fade-in">
    <div class="col-md-3">
        <div class="summary-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="summary-icon bg-pink-light">
                    <i class="fa-solid fa-rupiah-sign"></i>
                </div>
            </div>
            <p class="text-muted mb-1 fw-semibold">Pendapatan Hari Ini</p>
            <h4 class="fw-bold mb-0" style="color: var(--text-color)">Rp <span class="counter-up" data-value="{{ $totalSalesToday }}">0</span></h4>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="summary-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="summary-icon bg-purple-light">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
            <p class="text-muted mb-1 fw-semibold">Total Transaksi</p>
            <h4 class="fw-bold mb-0" style="color: var(--text-color)"><span class="counter-up" data-value="{{ $totalTransactionsToday }}">0</span> Struk</h4>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="summary-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="summary-icon bg-peach-light">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>
            <p class="text-muted mb-1 fw-semibold">Barang Terjual</p>
            <h4 class="fw-bold mb-0" style="color: var(--text-color)"><span class="counter-up" data-value="{{ $totalItemsSoldToday }}">0</span> Pcs</h4>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="summary-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="summary-icon bg-red-light">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
            </div>
            <p class="text-muted mb-1 fw-semibold">Stok Hampir Habis</p>
            <h4 class="fw-bold mb-0" style="color: var(--text-color)"><span class="counter-up" data-value="{{ $lowStockItems }}">0</span> Item</h4>
        </div>
    </div>
</div>

<div class="row fade-in">
    <!-- Top 5 Best Seller -->
    <div class="col-lg-5 mb-4">
        <div class="card summary-card p-4 h-100">
            <h5 class="fw-bold mb-4 brand-font" style="color: var(--gold-accent)"><i class="fa-solid fa-crown me-2"></i> Produk Terlaris</h5>
            
            @if(count($topProducts) > 0)
                <div class="list-group list-group-flush">
                    @foreach($topProducts as $top)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-3 bg-transparent" style="border-bottom: 1px dashed var(--border-color)">
                        <div class="d-flex align-items-center">
                            @if($top->barang && $top->barang->gambar)
                                <img src="{{ asset($top->barang->gambar) }}" alt="{{ $top->barang->nama_barang }}" class="rounded me-3 object-fit-cover shadow-sm" style="width: 45px; height: 45px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-3 shadow-sm border" style="width: 45px; height: 45px;">
                                    <i class="fa-solid fa-box text-muted"></i>
                                </div>
                            @endif
                            
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size: 0.95rem; color: var(--text-color)">{{ $top->barang ? $top->barang->nama_barang : 'Barang Terhapus' }}</h6>
                                <small class="text-muted"><i class="fa-solid fa-tag me-1"></i> {{ $top->barang ? $top->barang->kategori : '-' }}</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill bg-light text-dark fw-bold border shadow-sm px-3 py-2" style="font-size: 0.85rem">
                            {{ $top->total_terjual }} Terjual
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa-solid fa-box-open fa-3x text-muted mb-3 opacity-25"></i>
                    <p class="text-muted">Belum ada cukup data penjualan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Chart Penjualan Mingguan -->
    <div class="col-lg-7 mb-4">
        <div class="card summary-card p-4 h-100">
            <h5 class="fw-bold mb-4 brand-font" style="color: var(--text-color)"><i class="fa-solid fa-chart-line me-2" style="color: var(--accent-pink)"></i> Grafik Pendapatan 7 Hari Terakhir</h5>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart Kategori Pie -->
    <div class="col-lg-12">
        <div class="card summary-card p-4">
            <h5 class="fw-bold mb-4 brand-font" style="color: var(--text-color)"><i class="fa-solid fa-chart-pie me-2" style="color: var(--accent-pink)"></i> Analisis Kategori Terjual</h5>
            <div class="chart-container" style="height: 300px;">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Gradient fill for chart
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(209, 130, 158, 0.5)');   
    gradient.addColorStop(1, 'rgba(253, 242, 248, 0.1)');

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! $chartDates->toJson() !!},
            datasets: [{
                label: 'Total Pendapatan (Rp) ',
                data: {!! $chartSales->toJson() !!},
                borderColor: '#a18cd1',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#8f7cc3',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#5c4d51',
                    bodyColor: '#d1829e',
                    borderColor: '#f8c8dc',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(248, 200, 220, 0.2)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { family: "'Poppins', sans-serif" },
                        callback: function(value, index, values) {
                            if(value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                            if(value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
                            return 'Rp ' + value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: { family: "'Poppins', sans-serif" }
                    }
                }
            }
        }
    });

    const ctxPie = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: {!! $pieLabels->toJson() !!},
            datasets: [{
                data: {!! $pieData->toJson() !!},
                backgroundColor: [
                    '#d1829e', // accent pink
                    '#e09bb3', // lighter pink
                    '#d4af37', // gold
                    '#f8c8dc', // soft pink
                    '#f3d05b'  // light gold
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: { family: "'Poppins', sans-serif" }
                    }
                }
            }
        }
    });

    // Counter Up Animation
    document.querySelectorAll('.counter-up').forEach(el => {
        const target = +el.getAttribute('data-value');
        const duration = 1000;
        const inc = target / (duration / 16);
        let current = 0;
        
        const update = () => {
            current += inc;
            if (current < target) {
                el.innerText = Math.round(current).toLocaleString('id-ID');
                requestAnimationFrame(update);
            } else {
                el.innerText = target.toLocaleString('id-ID');
            }
        };
        if(target > 0) update();
    });
</script>
@endpush

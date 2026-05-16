@extends('layouts.app')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 fw-bold brand-font" style="color: var(--text-color)"><i class="fa-solid fa-clock-rotate-left me-2" style="color: var(--gold-accent)"></i> Riwayat Penjualan</h3>
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-custom rounded-pill">
                <i class="fa-solid fa-calculator me-1"></i> Kembali ke Kasir
            </a>
        </div>

        <div class="card summary-card shadow-sm border-0" style="border-radius: 20px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: var(--nude-beige); border-bottom: 2px solid var(--accent-purple);">
                            <tr>
                                <th class="py-3 ps-4" style="color: var(--accent-purple)"># Struk</th>
                                <th class="py-3" style="color: var(--accent-purple)">Tanggal & Jam</th>
                                <th class="py-3" style="color: var(--accent-purple)">Status</th>
                                <th class="py-3 text-end" style="color: var(--accent-purple)">Nominal Total</th>
                                <th class="py-3 text-center pe-4" style="color: var(--accent-purple)">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $trx)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">INV-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="fw-semibold" style="color: var(--text-color)">{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') }}</div>
                                    <div class="small text-muted">{{ $trx->created_at->format('H:i') }} WIB</div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; font-size: 0.75rem;">
                                        <i class="fa-solid fa-check-circle me-1"></i>Berhasil
                                    </span>
                                </td>
                                <td class="text-end fw-bold" style="color: var(--accent-purple)">
                                    Rp {{ number_format($trx->total, 0, ',', '.') }}
                                </td>
                                <td class="text-center pe-4">
                                    <button onclick="lihatDetail({{ $trx->id }}, 'INV-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}')" class="btn btn-sm px-3" style="background: linear-gradient(135deg, var(--primary-pink), var(--accent-purple)); color: white; border-radius: 10px; font-size: 0.8rem; transition: all 0.2s ease;">
                                        <i class="fa-solid fa-eye me-1"></i> Rincian
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fa-solid fa-receipt fa-3x mb-3" style="color: var(--accent-purple); opacity: 0.3;"></i>
                                    <h6 class="fw-bold brand-font" style="color: var(--text-color)">Belum Ada Transaksi</h6>
                                    <p class="text-muted small mb-0">Semua riwayat penjualan akan muncul di sini setelah transaksi pertama.</p>
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

<!-- Modal Rincian Transaksi -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden; background: var(--card-bg);">
            <div class="modal-header border-bottom-0" style="background-color: var(--border-color); color: var(--gold-accent);">
                <h5 class="modal-title fw-bold brand-font" id="modalTitle">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modalContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-pink" role="status"></div>
                    <p class="mt-2 text-muted">Memuat data struk...</p>
                </div>
            </div>
            <div class="modal-footer border-top-0 d-flex justify-content-between p-3" style="background: var(--bg-color);">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-custom rounded-pill px-4" onclick="printHistory()">
                    <i class="fa-solid fa-print me-1"></i> Print Ulang
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-pink { color: var(--accent-pink); }
</style>
@endpush

@push('scripts')
<script>
    const modalDetail = new bootstrap.Modal(document.getElementById('modalDetail'));
    const modalBody = document.getElementById('modalContent');
    const modalTitle = document.getElementById('modalTitle');

    function lihatDetail(id, inv) {
        modalTitle.innerText = 'Detail ' + inv;
        modalBody.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-pink" role="status"></div>
                <p class="mt-2 text-muted">Memuat data struk...</p>
            </div>
        `;
        modalDetail.show();

        fetch(`/history/detail/${id}`)
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    modalBody.innerHTML = data.html;
                } else {
                    modalBody.innerHTML = '<div class="alert alert-danger">Gagal memuat rincian!</div>';
                }
            })
            .catch(err => {
                modalBody.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan teknis.</div>';
            });
    }

    function printHistory() {
        let content = document.getElementById('modalContent').innerHTML;
        let title = document.getElementById('modalTitle').innerText;
        
        let printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>${title}</title>
                <style>
                    body { font-family: 'Courier New', Courier, monospace; max-width: 300px; margin: 0 auto; color: #000; }
                    .text-center { text-align: center; }
                    .d-flex { display: flex; }
                    .justify-content-between { justify-content: space-between; }
                    .fw-bold { font-weight: bold; }
                    .small { font-size: 12px; }
                    .text-muted { color: #555; }
                    .mb-0 { margin-bottom: 0; }
                    .mb-1 { margin-bottom: 5px; }
                    .mb-3 { margin-bottom: 15px; }
                    .pb-2 { padding-bottom: 10px; }
                    .border-bottom { border-bottom: 1px dashed #333; }
                    .brand { font-family: 'Times New Roman', serif; font-size: 20px; font-weight: bold; text-align: center; margin-bottom: 5px;}
                </style>
            </head>
            <body>
                <div class="text-center" style="margin-bottom: 5px;">
                    <img src="{{ asset('images/logo.png') }}" style="width: 50px; height: auto;">
                </div>
                <div class="brand">NESYÈL CLARITÉ</div>
                <div class="text-center small mb-3">Premium Beauty & Skincare</div>
                <div class="text-center pb-2 border-bottom fw-bold">${title}</div>
                <div style="margin-top: 15px;">
                    ${content}
                </div>
                <div style="border-top: 1px dashed #333; margin: 15px 0 10px 0;"></div>
                <div class="text-center small">
                    Terima Kasih Atas Kunjungan Anda<br>Barang yang sudah dibeli tidak dapat ditukar.
                </div>
                <script>
                    setTimeout(() => {
                        window.print();
                        window.close();
                    }, 500);
                <\/script>
            </body>
            </html>
        `);
    }
</script>
@endpush

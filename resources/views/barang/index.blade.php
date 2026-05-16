@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 head-title brand-font"><i class="fa-solid fa-box-open text-pink me-2"></i> Data Barang</h2>
    <a href="{{ route('barang.create') }}" class="btn btn-custom">
        <i class="fa-solid fa-plus me-1"></i> Tambah Barang
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background-color: var(--nude-beige);">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Gambar</th>
                        <th>Kategori</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $index => $item)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_barang }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div class="text-muted d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 8px; font-size: 0.8rem; background: var(--input-bg); border: 1px solid var(--border-color);">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td><span class="badge shadow-sm border" style="border-radius: 10px; background: var(--input-bg); color: var(--text-color); border-color: var(--border-color) !important;">{{ $item->kategori }}</span></td>
                        <td class="fw-medium">{{ $item->nama_barang }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>
                            @if($item->stok < 5)
                                <span class="badge bg-danger rounded-pill">{{ $item->stok }}</span>
                            @else
                                <span class="badge bg-success rounded-pill">{{ $item->stok }}</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" data-bs-toggle="tooltip" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle btn-delete" data-bs-toggle="tooltip" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fa-solid fa-box-open fa-3x mb-3" style="color: var(--accent-purple); opacity: 0.4;"></i>
                            <h6 class="fw-bold brand-font" style="color: var(--text-color)">Belum Ada Produk</h6>
                            <p class="text-muted small mb-3">Mulai tambahkan produk skincare & makeup ke inventori Anda.</p>
                            <a href="{{ route('barang.create') }}" class="btn btn-custom btn-sm px-4">
                                <i class="fa-solid fa-plus me-1"></i> Tambah Produk
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .text-pink { color: var(--accent-pink); }
    .text-light-pink { color: var(--secondary-pink); }
    .head-title { font-weight: 700; color: var(--text-color); }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Delete confirmation
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.form-delete');
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan lho!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff6b81',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });
</script>
@endpush

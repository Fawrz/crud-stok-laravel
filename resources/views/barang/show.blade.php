<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang: {{ $barang->nama_barang }} - Aplikasi Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}"> --}}
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('barang.index') }}">Aplikasi Stok Toko</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('barang.index') }}">Daftar Barang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 main-content-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mb-0">Detail Barang</h1>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Kode: {{ $barang->kode }}</h6>
                        
                        @if ($barang->foto)
                            <div class="my-3 text-center">
                                <img src="{{ asset('storage/uploads/barang/' . $barang->foto) }}" alt="{{ htmlspecialchars($barang->nama_barang) }}" style="max-width: 150px; max-height: 150px; border:1px solid #ddd;">
                            </div>
                        @endif

                        <p class="card-text"><strong>Deskripsi:</strong><br>
                            {!! nl2br(e($barang->deskripsi)) ?: '-' !!}
                        </p>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Harga Satuan:</strong> Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</li>
                            <li class="list-group-item"><strong>Jumlah Stok:</strong> {{ $barang->jumlah }}</li>
                            <li class="list-group-item"><strong>Ditambahkan Pada:</strong> {{ $barang->created_at ? $barang->created_at->format('d M Y, H:i:s') : '-' }}</li>
                            <li class="list-group-item"><strong>Terakhir Diperbarui:</strong> {{ $barang->updated_at ? $barang->updated_at->format('d M Y, H:i:s') : '-' }}</li>
                        </ul>
                    </div>
                    <div class="card-footer text-muted">
                        <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm">Kembali ke Daftar</a>
                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">Edit Barang Ini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
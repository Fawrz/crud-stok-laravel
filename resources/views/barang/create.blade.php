<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang Baru - Aplikasi Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}"> --}}
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('barang.index') }}">Aplikasi Stok Barang (Laravel)</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('barang.index') }}">Daftar Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('barang.create') }}">Tambah Barang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1>Tambah Barang Baru</h1></div>
                    <div class="card-body">
                        {{-- Menampilkan error validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf {{-- Token CSRF untuk keamanan --}}

                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode" value="{{ old('kode') }}" required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                                @error('nama_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="harga_satuan" class="form-label">Harga Satuan (Rp)</label>
                                <input type="number" class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan') }}" required min="0" step="any">
                                @error('harga_satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Stok</label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required min="0">
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto Barang</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto">
                                <div class="form-text">Ukuran foto maksimal 2MB. Format: JPG, JPEG, PNG, GIF.</div>
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Barang</button>
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
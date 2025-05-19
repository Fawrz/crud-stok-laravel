<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang - Aplikasi Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <a class="nav-link active" aria-current="page" href="{{ route('barang.index') }}">Daftar Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('barang.create') }}">Tambah Barang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Daftar Barang</h1>
            <a href="{{ route('barang.create') }}" class="btn btn-success">Tambah Barang Baru</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr>
                            <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}</td>
                            <td>{{ $barang->kode }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</td>
                            <td>{{ $barang->jumlah }}</td>
                            <td>
                                @if ($barang->foto)
                                    {{ $barang->foto }}
                                    {{-- <img src="{{ asset('uploads/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" width="75" class="img-thumbnail"> --}}
                                @else
                                    Tidak ada foto
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-info btn-sm me-1 mb-1">Lihat</a>
                                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm me-1 mb-1">Edit</a>
                                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini: {{ addslashes(htmlspecialchars($barang->nama_barang)) }}?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-center">
            {{ $barangs->links() }}
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
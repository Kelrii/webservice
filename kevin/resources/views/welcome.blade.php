@extends('masterlayout')

@section('content')
    <div class="container py-3">
        @php
            $alertMessage = session('success') ?? 'Biodata berhasil diperbarui.';
        @endphp

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $alertMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 border rounded-3 shadow-sm">
                    <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 460px;">
                        <button type="button"
                            class="btn rounded-circle d-flex justify-content-center align-items-center border-0 shadow-sm add-card-btn"
                            data-bs-toggle="modal" data-bs-target="#tambahBiodataModal" aria-label="Tambah Biodata">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" fill="none"
                                stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                viewBox="0 0 24 24">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            @foreach ($biodatas as $item)
                <x-ui.card :id="$item['id']" :nama="$item['nama']" :deskripsi="$item['deskripsi']" :foto="$item['foto']" />
            @endforeach
        </div>
    </div>

    <!-- Modal Tambah Biodata -->
    <div class="modal fade" id="tambahBiodataModal" tabindex="-1" aria-labelledby="tambahBiodataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('biodata.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahBiodataModalLabel">Tambah Biodata</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tambah-nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="tambah-nama" name="nama"
                                placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="tambah-deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="tambah-deskripsi" name="deskripsi" rows="3"
                                placeholder="Contoh: dengan NIM 12.11.xxxx bertugas sebagai..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tambah-foto-file" class="form-label">Upload Foto (Opsional)</label>
                            <input type="file" class="form-control" id="tambah-foto-file" name="foto_file"
                                accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="tambah-foto-url" class="form-label">Atau URL Foto (Opsional)</label>
                            <input type="url" class="form-control" id="tambah-foto-url" name="foto_url"
                                placeholder="https://contoh.com/foto.jpg">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Biodata -->
    @foreach ($biodatas as $item)
        <div class="modal fade" id="editBiodataModal-{{ $item['id'] }}" tabindex="-1"
            aria-labelledby="editBiodataModalLabel-{{ $item['id'] }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('biodata.update', $item['id']) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editBiodataModalLabel-{{ $item['id'] }}">Edit Biodata</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit-nama-{{ $item['id'] }}" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="edit-nama-{{ $item['id'] }}"
                                    name="nama" value="{{ $item['nama'] }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-deskripsi-{{ $item['id'] }}" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="edit-deskripsi-{{ $item['id'] }}" name="deskripsi" rows="3"
                                    required>{{ $item['deskripsi'] }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="edit-foto-file-{{ $item['id'] }}" class="form-label">Ganti Foto
                                    (Upload)</label>
                                <input type="file" class="form-control" id="edit-foto-file-{{ $item['id'] }}"
                                    name="foto_file" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="edit-foto-url-{{ $item['id'] }}" class="form-label">Atau URL Foto Baru
                                    (Opsional)</label>
                                <input type="url" class="form-control" id="edit-foto-url-{{ $item['id'] }}"
                                    name="foto_url" placeholder="https://contoh.com/foto.jpg">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@props([
    'id' => null,
    'nama' => 'Nama',
    'deskripsi' => 'Deskripsi',
    'foto' => asset('images/avatar-1.svg'),
])

<div class="col">
    <div class="card h-100 border rounded-3 shadow-sm overflow-hidden">
        <img src="{{ $foto }}" class="card-img-top" alt="{{ $nama }}"
            style="height: 300px; object-fit: cover; object-position: top;">
        <div class="card-body d-flex flex-column px-3 pt-3 pb-3">
            <h5 class="card-title fw-bold mb-2">{{ $nama }}</h5>
            <p class="card-text text-secondary mb-4" style="font-size: 0.92rem; line-height: 1.45;">
                {{ $deskripsi }}
            </p>
            <div class="mt-auto pt-3 border-top d-flex gap-2">
                <button type="button" class="btn btn-outline-primary btn-sm px-2 py-1" data-bs-toggle="modal"
                    data-bs-target="#editBiodataModal-{{ $id }}">
                    Edit
                </button>
                <form action="{{ route('biodata.destroy', $id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus biodata {{ addslashes($nama) }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm px-2 py-1">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

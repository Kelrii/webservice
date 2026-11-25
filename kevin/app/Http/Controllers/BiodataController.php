<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class BiodataController extends Controller
{
    /**
     * Default biodata cards matching the initial layout.
     *
     * @return array<int, array<string, mixed>>
     */
    private function defaultItems(): array
    {
        return [
            [
                'id' => 1,
                'nama' => 'rizki eka prasodjo',
                'deskripsi' => '12.11.5866 merupakan master dari uts ini dengan tugas membuat front-end dan mengirimkannya ke grup',
                'foto' => asset('images/avatar-1.svg'),
            ],
            [
                'id' => 2,
                'nama' => 'andi agus salim',
                'deskripsi' => 'dengan NIM 12.11.6018 merupakan pegawai dan mempunyai tugas mengerjakan back-end pada UTS ini',
                'foto' => asset('images/avatar-2.svg'),
            ],
        ];
    }

    /**
     * Display the biodata card grid.
     */
    public function index(): View
    {
        if ($this->hasDatabaseTable()) {
            $biodatas = Biodata::query()->orderBy('id')->get()->map(fn (Biodata $item) => [
                'id' => $item->id,
                'nama' => $item->nama,
                'deskripsi' => $item->deskripsi,
                'foto' => $this->resolveFotoUrl($item->foto, $item->id),
            ])->all();
        } else {
            if (! session()->has('biodatas_fallback')) {
                session(['biodatas_fallback' => $this->defaultItems()]);
            }
            $biodatas = session('biodatas_fallback', []);
        }

        return view('welcome', compact('biodatas'));
    }

    /**
     * Store a newly created biodata card.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:1000'],
            'foto_file' => ['nullable', 'image', 'max:2048'],
            'foto_url' => ['nullable', 'string', 'max:500'],
        ]);

        $fotoPath = $this->handleFotoUpload($request) ?? ($validated['foto_url'] ?: 'images/avatar-1.svg');

        if ($this->hasDatabaseTable()) {
            Biodata::create([
                'nama' => $validated['nama'],
                'deskripsi' => $validated['deskripsi'],
                'foto' => $fotoPath,
            ]);
        } else {
            $items = session('biodatas_fallback', $this->defaultItems());
            $nextId = empty($items) ? 1 : (max(array_column($items, 'id')) + 1);
            $items[] = [
                'id' => $nextId,
                'nama' => $validated['nama'],
                'deskripsi' => $validated['deskripsi'],
                'foto' => $this->resolveFotoUrl($fotoPath, $nextId),
            ];
            session(['biodatas_fallback' => $items]);
        }

        return redirect()->route('home')->with('success', 'Biodata berhasil ditambahkan.');
    }

    /**
     * Update an existing biodata card.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:1000'],
            'foto_file' => ['nullable', 'image', 'max:2048'],
            'foto_url' => ['nullable', 'string', 'max:500'],
        ]);

        $uploadedFoto = $this->handleFotoUpload($request);

        if ($this->hasDatabaseTable()) {
            $biodata = Biodata::findOrFail($id);
            $foto = $uploadedFoto ?? ($validated['foto_url'] ?: $biodata->foto);
            $biodata->update([
                'nama' => $validated['nama'],
                'deskripsi' => $validated['deskripsi'],
                'foto' => $foto,
            ]);
        } else {
            $items = session('biodatas_fallback', $this->defaultItems());
            foreach ($items as &$item) {
                if ((int) $item['id'] === $id) {
                    $item['nama'] = $validated['nama'];
                    $item['deskripsi'] = $validated['deskripsi'];
                    if ($uploadedFoto !== null) {
                        $item['foto'] = $this->resolveFotoUrl($uploadedFoto, $id);
                    } elseif (! empty($validated['foto_url'])) {
                        $item['foto'] = $this->resolveFotoUrl($validated['foto_url'], $id);
                    }
                    break;
                }
            }
            unset($item);
            session(['biodatas_fallback' => $items]);
        }

        return redirect()->route('home')->with('success', 'Biodata berhasil diperbarui.');
    }

    /**
     * Remove a biodata card.
     */
    public function destroy(int $id): RedirectResponse
    {
        if ($this->hasDatabaseTable()) {
            Biodata::findOrFail($id)->delete();
        } else {
            $items = array_values(array_filter(
                session('biodatas_fallback', $this->defaultItems()),
                fn (array $item) => (int) $item['id'] !== $id
            ));
            session(['biodatas_fallback' => $items]);
        }

        return redirect()->route('home')->with('success', 'Biodata berhasil dihapus.');
    }

    private function hasDatabaseTable(): bool
    {
        try {
            return Schema::hasTable('biodatas');
        } catch (\Throwable) {
            return false;
        }
    }

    private function handleFotoUpload(Request $request): ?string
    {
        if (! $request->hasFile('foto_file')) {
            return null;
        }

        $file = $request->file('foto_file');
        $uploadDir = public_path('uploads/biodata');
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $file->move($uploadDir, $filename);

        return 'uploads/biodata/'.$filename;
    }

    private function resolveFotoUrl(?string $foto, int $id): string
    {
        if (empty($foto)) {
            return asset($id % 2 === 0 ? 'images/avatar-2.svg' : 'images/avatar-1.svg');
        }

        if (str_starts_with($foto, 'http://') || str_starts_with($foto, 'https://') || str_starts_with($foto, 'data:')) {
            return $foto;
        }

        return asset(ltrim($foto, '/'));
    }
}

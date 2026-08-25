<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JenisLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jenisLayanans = JenisLayanan::when($request->search, function ($query, $search) {
            return $query->search($search);
        })
        ->when($request->status_filter !== null && $request->status_filter !== '', function ($query) use ($request) {
            return $query->where('is_active', $request->status_filter);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

        // Statistik
        $stats = [
            'total' => JenisLayanan::count(),
            'aktif' => JenisLayanan::where('is_active', true)->count(),
            'nonaktif' => JenisLayanan::where('is_active', false)->count(),
        ];

        // Role tujuan untuk dropdown
        $roleTujuan = [
            'kutipan_kedua' => 'Kutipan Kedua',
            'keabsahan' => 'Keabsahan',
            'surat_pengantar' => 'Surat Pengantar',
        ];

        return view('admin.jenis-layanan.index', compact(
            'jenisLayanans',
            'stats',
            'roleTujuan'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roleTujuan = [
            'kutipan_kedua' => 'Kutipan Kedua',
            'keabsahan' => 'Keabsahan',
            'surat_pengantar' => 'Surat Pengantar',
        ];

        return view('admin.jenis-layanan.create', compact('roleTujuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:150|unique:jenis_layanans,nama_layanan',
            'kode_layanan' => 'required|string|max:50|unique:jenis_layanans,kode_layanan|regex:/^[A-Z_]+$/',
            'role_tujuan' => 'required|in:kutipan_kedua,keabsahan,surat_pengantar',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'kode_layanan.regex' => 'Kode layanan hanya boleh menggunakan huruf kapital dan underscore (_)',
            'kode_layanan.unique' => 'Kode layanan sudah digunakan',
            'nama_layanan.unique' => 'Nama layanan sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $jenisLayanan = JenisLayanan::create([
                'nama_layanan' => $request->nama_layanan,
                'kode_layanan' => Str::upper($request->kode_layanan),
                'role_tujuan' => $request->role_tujuan,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->has('is_active'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jenis layanan berhasil ditambahkan!',
                'data' => $jenisLayanan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisLayanan $jenisLayanan)
    {
        return response()->json([
            'success' => true,
            'data' => $jenisLayanan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisLayanan $jenisLayanan)
    {
        $roleTujuan = [
            'kutipan_kedua' => 'Kutipan Kedua',
            'keabsahan' => 'Keabsahan',
            'surat_pengantar' => 'Surat Pengantar',
        ];

        return view('admin.jenis-layanan.edit', compact('jenisLayanan', 'roleTujuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisLayanan $jenisLayanan)
    {
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:150|unique:jenis_layanans,nama_layanan,' . $jenisLayanan->id,
            'kode_layanan' => 'required|string|max:50|unique:jenis_layanans,kode_layanan,' . $jenisLayanan->id . '|regex:/^[A-Z_]+$/',
            'role_tujuan' => 'required|in:kutipan_kedua,keabsahan,surat_pengantar',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ], [
            'kode_layanan.regex' => 'Kode layanan hanya boleh menggunakan huruf kapital dan underscore (_)',
            'kode_layanan.unique' => 'Kode layanan sudah digunakan',
            'nama_layanan.unique' => 'Nama layanan sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $jenisLayanan->update([
                'nama_layanan' => $request->nama_layanan,
                'kode_layanan' => Str::upper($request->kode_layanan),
                'role_tujuan' => $request->role_tujuan,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->has('is_active'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jenis layanan berhasil diperbarui!',
                'data' => $jenisLayanan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisLayanan $jenisLayanan)
    {
        try {
            // Cek apakah ada permohonan yang menggunakan layanan ini
            if ($jenisLayanan->permohonans()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan ini tidak dapat dihapus karena masih digunakan pada permohonan.'
                ], 422);
            }

            $nama = $jenisLayanan->nama_layanan;
            $jenisLayanan->delete();

            return response()->json([
                'success' => true,
                'message' => "Layanan '{$nama}' berhasil dihapus!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle status layanan.
     */
    public function toggleStatus(JenisLayanan $jenisLayanan)
    {
        try {
            $jenisLayanan->update([
                'is_active' => !$jenisLayanan->is_active
            ]);

            $status = $jenisLayanan->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return response()->json([
                'success' => true,
                'message' => "Layanan '{$jenisLayanan->nama_layanan}' berhasil {$status}!",
                'data' => $jenisLayanan
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
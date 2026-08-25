<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::search($request->search)
            ->filterRole($request->role)
            ->filterStatus($request->status)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();


        // Daftar role untuk filter
        $roles = [
            'admin' => 'Administrator',
            'petugas_loket' => 'Petugas Loket',
            'pengecekan_kehilangan' => 'Pengecekan Kehilangan',
            'kutipan_kedua' => 'Kutipan Kedua',
            'banjir_kepolisian' => 'Banjir Kepolisian',
            'keabsahan' => 'Keabsahan',
            'surat_pengantar' => 'Surat Pengantar',
        ];

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas_loket,pengecekan_kehilangan,kutipan_kedua,banjir_kepolisian,keabsahan,surat_pengantar',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password), // PASTIKAN HASH::make
                'role' => $request->role,
                'phone' => $request->phone,
                'is_active' => $request->has('is_active'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil ditambahkan!',
                'data' => $user
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
    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,petugas_loket,pengecekan_kehilangan,kutipan_kedua,banjir_kepolisian,keabsahan,surat_pengantar',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'role' => $request->role,
                'phone' => $request->phone,
                'is_active' => $request->has('is_active'),
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password); // PASTIKAN HASH::make
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil diperbarui!',
                'data' => $user
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
    public function destroy(User $user)
    {
        try {
            // Cegah menghapus diri sendiri
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menghapus akun sendiri!'
                ], 422);
            }

            $name = $user->name;
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => "Pengguna '{$name}' berhasil dihapus!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle status user.
     */
    public function toggleStatus(User $user)
    {
        try {
            // Cegah menonaktifkan diri sendiri
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menonaktifkan akun sendiri!'
                ], 422);
            }

            $user->update([
                'is_active' => !$user->is_active
            ]);

            $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return response()->json([
                'success' => true,
                'message' => "Pengguna '{$user->name}' berhasil {$status}!",
                'data' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request, User $user)
    {
        try {
            $newPassword = 'password123';

            $user->update([
                'password' => Hash::make($newPassword) // PASTIKAN HASH::make
            ]);

            return response()->json([
                'success' => true,
                'message' => "Password pengguna '{$user->name}' berhasil direset!",
                'new_password' => $newPassword
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
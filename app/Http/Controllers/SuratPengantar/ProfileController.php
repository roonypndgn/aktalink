<?php
namespace App\Http\Controllers\SuratPengantar;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\LogsActivity; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    use LogsActivity;
    /**
     * Display user profile.
     */
    public function index()
    {
        $user = Auth::user();
        return view('surat-pengantar.profile.index', compact('user'));
    }

    /**
     * Update profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'phone' => 'nullable|string|max:20',
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
                'phone' => $request->phone,
            ];

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui!',
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
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini salah!'
            ], 422);
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::disk('public')->exists('photos/' . $user->photo)) {
                Storage::disk('public')->delete('photos/' . $user->photo);
            }

            $file = $request->file('photo');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('photos', $fileName, 'public');

            $user->update(['photo' => $fileName]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui!',
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
     * Delete profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        try {
            if ($user->photo && Storage::disk('public')->exists('photos/' . $user->photo)) {
                Storage::disk('public')->delete('photos/' . $user->photo);
            }

            $user->update(['photo' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
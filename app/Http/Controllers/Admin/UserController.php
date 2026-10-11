<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // 1. Tampilkan Daftar Pengguna
    public function index(Request $request)
    {
        $query = User::with('classroom.program');

        // Fitur Filter Role (Admin, Guru, Siswa)
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Fitur Pencarian (Nama / Username / Email)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $classrooms = Classroom::with('program')->get();

        return view('admin.users.index', compact('users', 'classrooms'));
    }

    // 2. Simpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username',
            'email'        => 'required|string|email|max:255|unique:users,email',
            'password'     => 'required|string|min:6',
            'role'         => 'required|in:admin,guru,siswa',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        User::create([
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'classroom_id' => $request->role === 'siswa' ? $request->classroom_id : null,
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // 3. Update Data User
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'username'     => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email'        => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'         => 'required|in:admin,guru,siswa',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        $user->update([
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->email,
            'role'         => $request->role,
            'classroom_id' => $request->role === 'siswa' ? $request->classroom_id : null,
        ]);

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // 4. Reset Password Pengguna
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password pengguna berhasil direset!');
    }

    // 5. Hapus User
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }
}

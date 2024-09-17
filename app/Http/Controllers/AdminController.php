<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Logika untuk dashboard admin
        $userCount = User::count();
        $postCount = Post::count();
        return view('admin.dashboard', compact('userCount', 'postCount'));
    }

    public function users()
    {
        // Logika untuk halaman manajemen pengguna
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    public function posts(Request $request)
    {
        $limit = $request->input('limit', 10);
        $posts = Post::with('user')->latest()->paginate($limit);
        return view('admin.posts', compact('posts', 'limit'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $user->update($validatedData);

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function toggleUserSuspension(User $user)
    {
        $user->toggleSuspension();
        return redirect()->back()->with('success', "Status pengguna diperbarui menjadi {$user->status}");
    }

    public function showPost(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function editPost(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function updatePost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'start_point' => 'required|json',
            'end_point' => 'required|json',
            // tambahkan validasi lain sesuai kebutuhan
        ]);

        $validated['start_point'] = json_decode($validated['start_point'], true);
        $validated['end_point'] = json_decode($validated['end_point'], true);

        $post->update($validated);

        return redirect()->route('admin.posts')->with('success', 'Posting berhasil diperbarui.');
    }

    public function togglePostSuspension(Post $post)
    {
        $post->toggleSuspension();
        return redirect()->back()->with('success', "Status postingan diperbarui menjadi {$post->status}");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna baru berhasil ditambahkan');
    }

    public function dashboard()
    {
        $users = User::all();
        $posts = Post::with('user')->get();
        return view('admin.dashboard', compact('users', 'posts'));
    }
    public function createPost()
    {
        return view('admin.posts.create');
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'start_point' => 'required|json',
            'end_point' => 'required|json',
        ]);

        $validated['start_point'] = json_decode($validated['start_point'], true);
        $validated['end_point'] = json_decode($validated['end_point'], true);

        $post = new Post($validated);
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('admin.posts')->with('success', 'Postingan berhasil ditambahkan.');
    }
}

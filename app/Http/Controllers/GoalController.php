<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        // Mengambil semua goal yang dimiliki oleh user yang sedang login
        $goals = Goal::where('user_id', Auth::id())->get();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang dimasukkan oleh user
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'target' => 'required|integer|min:1',
        ]);

        // Membuat goal baru
        Goal::create([
            'title' => $request->title,
            'description' => $request->description,
            'target' => $request->target,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('goals.index')->with('success', 'Goal berhasil dibuat!');
    }

    public function edit(Goal $goal)
    {
        // Pastikan hanya user yang memiliki goal yang bisa mengeditnya
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal)
    {
        // Pastikan hanya goal milik user yang bisa diupdate
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Validasi inputan
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'target' => 'required|integer|min:1',
        ]);

        // Update data goal
        $goal->update($request->only('title', 'description', 'target'));

        return redirect()->route('goals.index')->with('success', 'Goal berhasil diperbarui!');
    }

    public function destroy(Goal $goal)
    {
        // Pastikan hanya goal milik user yang bisa dihapus
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $goal->delete();

        return redirect()->route('goals.index')->with('success', 'Goal berhasil dihapus!');
    }

    public function updateProgress(Request $request, Goal $goal)
    {
        // Pastikan hanya goal milik user yang bisa diupdate progress-nya
        if ($goal->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'progress_update' => 'required|integer|min:0',
        ]);

        // Increment progress goal
        $goal->increment('progress', $request->progress_update);

        return redirect()->route('goals.index')->with('success', 'Progress berhasil ditambahkan!');
    }
}

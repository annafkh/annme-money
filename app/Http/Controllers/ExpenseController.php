<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())->latest()->get();
        return view('expense.index', compact('expenses'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->where('type', 'expense')->get();
        return view('expense.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('expense.index')->with('success', 'Pengeluaran ditambahkan!');
    }

    public function edit(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        $expense->date = \Carbon\Carbon::parse($expense->date);
        $categories = Category::where('user_id', Auth::id())->where('type', 'expense')->get();
        return view('expense.create', compact('categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $expense->update($request->only('title', 'amount', 'date','category_id',));

        return redirect()->route('expense.index')->with('success', 'Pengeluaran diperbarui!');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Pengeluaran dihapus!');
    }
}


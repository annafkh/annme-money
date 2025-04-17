<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())->latest()->get();
        return view('expense.index', compact('expenses'));
    }

    public function create()
    {
        return view('expense.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->route('expense.index')->with('success', 'Pengeluaran ditambahkan!');
    }

    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);
        return view('expense.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $expense->update($request->only('title', 'amount', 'date'));

        return redirect()->route('expense.index')->with('success', 'Pengeluaran diperbarui!');
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();

        return redirect()->route('expense.index')->with('success', 'Pengeluaran dihapus!');
    }
}


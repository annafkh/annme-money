<?php
namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::where('user_id', Auth::id())->latest()->get();
        return view('income.index', compact('incomes'));
    }

    public function create()
    {
        return view('income.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Income::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->route('income.index')->with('success', 'Pemasukan ditambahkan!');
    }

    public function edit(Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        $income->date = \Carbon\Carbon::parse($income->date);
        return view('income.edit', compact('income'));
    }

    public function update(Request $request, Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $income->update($request->only('title', 'amount', 'date'));

        return redirect()->route('income.index')->with('success', 'Pemasukan diperbarui!');
    }

    public function destroy(Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        $income->delete();

        return redirect()->route('income.index')->with('success', 'Pemasukan dihapus!');
    }
}
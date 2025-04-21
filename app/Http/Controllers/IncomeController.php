<?php
namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::where('user_id', Auth::id())->latest()->get();
        return view('income.index', compact('incomes'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->where('type', 'income')->get();
        return view('income.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $cleanAmount = preg_replace('/[^\d]/', '', $request->amount);
    
        $request->merge([
            'amount' => $cleanAmount
        ]);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);
    
        Income::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'category_id' => $request->category_id,
        ]);
    
        return redirect()->route('income.index')->with('success', 'Pemasukan ditambahkan!');
    }    

    public function edit(Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
    
        $income->date = \Carbon\Carbon::parse($income->date);
    
        $categories = Category::where('user_id', Auth::id())->where('type', 'income')->get();
        return view('income.edit', compact('income', 'categories'));
    }    

    public function update(Request $request, Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $cleanAmount = preg_replace('/[^\d]/', '', $request->amount);
        $request->merge([
            'amount' => $cleanAmount
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $income->update($request->only('title', 'amount', 'date','category_id',));

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
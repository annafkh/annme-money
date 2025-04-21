<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
    
        // Ambil parameter filter
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $keyword = $request->input('keyword');
        $categoryId = $request->input('category_id');  // Kategori yang dipilih
    
        // Query income dengan filter
        $incomeQuery = Income::where('user_id', $userId);
        if ($fromDate) {
            $incomeQuery->whereDate('date', '>=', $fromDate);
        }
        if ($toDate) {
            $incomeQuery->whereDate('date', '<=', $toDate);
        }
        if ($keyword) {
            $incomeQuery->where('title', 'like', '%' . $keyword . '%');
        }
        if ($categoryId) {
            $incomeQuery->where('category_id', $categoryId);  // Filter berdasarkan kategori
        }
    
        // Query expense dengan filter
        $expenseQuery = Expense::where('user_id', $userId);
        if ($fromDate) {
            $expenseQuery->whereDate('date', '>=', $fromDate);
        }
        if ($toDate) {
            $expenseQuery->whereDate('date', '<=', $toDate);
        }
        if ($keyword) {
            $expenseQuery->where('title', 'like', '%' . $keyword . '%');
        }
        if ($categoryId) {
            $expenseQuery->where('category_id', $categoryId);  // Filter berdasarkan kategori
        }
    
        // Ambil data kategori
        $categories = Category::all();
    
        // Mengambil transaksi terbaru sesuai filter
        $totalIncome = Income::where('user_id', $userId)->sum('amount');
        $totalExpense = Expense::where('user_id', $userId)->sum('amount');
        $balance = $totalIncome - $totalExpense;
    
        // Get recent transactions with filter applied
        $recentIncome = $incomeQuery->latest()->get()->map(function ($item) {
            $item->type = 'income';
            return $item;
        });
    
        $recentExpense = $expenseQuery->latest()->get()->map(function ($item) {
            $item->type = 'expense';
            return $item;
        });
    
        $recentTransactions = $recentIncome->concat($recentExpense)->sortByDesc('date');
    
        // Kirim data ke view
        return view('dashboard', compact(
            'balance',
            'totalIncome',
            'totalExpense',
            'recentTransactions',
            'categories' // Pastikan variabel kategori dikirim ke view
        ));
    }    
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Filter dari request
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $keyword = $request->input('keyword');

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

        $recentTransactions = $recentIncome->merge($recentExpense)->sortByDesc('created_at')->take(5);

        return view('dashboard', compact(
            'balance',
            'totalIncome',
            'totalExpense',
            'recentTransactions'
        ));
    }
}

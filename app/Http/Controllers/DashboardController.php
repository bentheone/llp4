<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showStats() {
        $user = auth()->user();

        $productCount = $user->products()->count();
        $stockInCount = $user->stockIns()->count();
        $stockOutCount = $user->stockOuts()->count();

        return view('dashboard', compact('productCount', 'stockInCount', 'stockOutCount'));
    }
}

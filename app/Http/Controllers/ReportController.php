<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function getReportPage()
    {
        $user = Auth::user();
        return view('report', compact('user'));
    }
    public function getReport(Request $request)
    {
        $reportData = [];
        $request->validate([
            'date'=>'required|date|before_or_equal:today'
        ]);

        $date = Carbon::parse($request->date)->toDateString();
        $user = Auth::user();
        $products = $user->products()
        ->with([
            'stockIns'=> function ($query) use ($date) {
                $query->whereDate('created_at', $date);
            },
            'stockOuts'=> function ($query) use ($date) {
                $query->whereDate('created_at', $date);
            }
        ])->get();

        foreach ($products as $product) {
            if ($product->stockIns->isEmpty() && $product->stockOuts->isEmpty()) {
                continue;
            }

            $stockInQty = $product->stockIns->sum('quantity');
            $stockInAmount = $product->stockIns->sum('total_price');

            $stockOutQty = $product->stockOuts->sum('quantity');
            $stockOutAmount = $product->stockOuts->sum('total_price');

            $reportData[] = [
                'product_name' => $product->name,
                'stock_in_qty' => $stockInQty,
                'stock_in_amount' => $stockInAmount,
                'stock_out_qty' => $stockOutQty,
                'stock_out_amount' => $stockOutAmount,
                'amount_difference' =>  $stockOutAmount - $stockInAmount,
            ];
        }
        return view('report',compact('reportData'));

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'name',
        'quantity',
        'price',
        'category'
    ];

    public function stockOuts() {
        return $this->hasMany(StockOut::class);
    }
    
    public function stockIns() {
        return $this->hasMany(StockIn::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

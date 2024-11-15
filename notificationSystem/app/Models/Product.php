<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = ['name', 'quantity_in_stock', 'minimum_threshold','category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function buy(int $quantity)
    {
        $this->quantity_in_stock += $quantity;
        $this->save();
    }

    public function sell(int $quantity)
    {
        if ($quantity > $this->quantity_in_stock) {
            throw new \Exception("Low stock quantity");
        }

        $this->quantity_in_stock -= $quantity;
        $this->save();
    }
}

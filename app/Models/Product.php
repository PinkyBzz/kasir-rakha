<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','sku','description','price','stock','pack_size','pack_label','discount_type','discount_value','image_path'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_value' => 'decimal:2',
    ];

    public function getFinalPriceAttribute(): string
    {
        $price = $this->price;
        if ($this->discount_type === 'percent') {
            $price = $price * (1 - ($this->discount_value/100));
        } elseif ($this->discount_type === 'nominal') {
            $price = max(0, $price - $this->discount_value);
        }
        return number_format($price, 2, '.', '');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'location_id',
        'product_id',
        'date',
        'car_id'
    ];
    protected $appends = [
        'product_detail',
        'location_detail',
        'car_detail',
    ];

    public function productDetail(): Attribute {
        return Attribute::make(
           get: fn() => Product::where('id', $this->product_id)->select('title', 'price')->first()
        );
    }
    public function locationDetail(): Attribute {
        return Attribute::make(
            get: fn() => Location::where('id', $this->location_id)->first()
        );
    }
    public function carDetail(): Attribute {
        return Attribute::make(
            get: fn() => Car::where('id', $this->car_id)->first()
        );
    }
}

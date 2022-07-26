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
    protected $hidden = [
      'user_id',
      'location_id',
      'product_id',
        'car_id',
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
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}

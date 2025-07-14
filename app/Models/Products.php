<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;


class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'tax',
        'features', // 'percentage' or 'fixed'
        'assigned_name',
    ];

     protected $casts = [
        'price' => 'float',
        'tax' => 'float',
        'features' => 'array'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

   public function getTaxAmountAttribute()
    {
        return $this->price * ($this->tax / 100);
    }

    public function getTotalAmountAttribute()
    {
        return $this->price + $this->tax_amount;
    }


}
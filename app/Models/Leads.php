<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
// use DateTimeInterface;

// class Leads extends Model
// {
//     use HasFactory, SoftDeletes;

//     protected $table = 'leads';

//     protected $dates = [
//         'created_at',
//         'updated_at',
//         'deleted_at',
//     ];

//     protected $fillable = [
//         'user_id',
//         'name',
//         'mobile',
//         'email',
//         'address',
//         'industry',
//         'purpose',
//         'status',
//         'source',
//         'product_ids',
//         'remarks',
//         'mail_status',
//         'assigned_name',
//         'assigned_by_id',
//         'assigned_to_remarks',
//         'demo_date',
//         'demo_time',
//         'demo_mail_status',
//         'follow_date',
//         'follow_time',
//         'follow_mail_status',
//         'call_back_date',
//         'call_back_time',
//         'quotation_amount',
//         'quotation_tax',
//         'quotation_reference',
//         'quotation_validity',
//         'quotation_expiry_date',
//         'quotation_terms',
//         'quotation_notes',
//         'about_us',
//         'created_at',
//         'updated_at',
//         'opened_at',
//         'is_pinned',
//         'last_updated_by',
//         'deleted_at',
//     ];

//     public const MAIL_STATUS = [
//         '1' => 'Yes',
//         '0' => 'No',
//     ];

//     protected $casts = [
//         'product_ids' => 'array',
//         'quotation_terms' => 'array',
//     ];

//     protected function serializeDate(DateTimeInterface $date)
//     {
//         return $date->format('Y-m-d H:i:s');
//     }




//     public function products()
// {
//     return $this->belongsToMany(Products::class, 'lead_product', 'lead_id', 'product_id');

// }

//     public function user()
//     {
//         return $this->belongsTo(User::class, 'user_id');
//     }
//     public function assign()
//     {
//         return $this->belongsTo(User::class, 'assigned_name');
//     }

//     public function assignedBy()
//     {
//         return $this->belongsTo(User::class, 'assigned_by_id');
//     }

//     public function lastUpdateBy()
//     {
//         return $this->belongsTo(User::class, 'last_updated_by');
//     }
//     // Calculate total amount with tax
//     public function getTotalAmountAttribute()
//     {
//         $subtotal = $this->quotation_amount ?? 0;
//         $tax = $this->quotation_tax ?? 0;
//         return $subtotal + ($subtotal * $tax / 100);
//     }

// }


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class Leads extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'leads';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'opened_at',
        'quotation_expiry_date'
    ];

    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'email',
        'address',
        'industry',
        'purpose',
        'status',
        'source',
        'product_ids',
        'remarks',
        'mail_status',
        'assigned_name',
        'assigned_by_id',
        'assigned_to_remarks',
        'demo_date',
        'demo_time',
        'demo_mail_status',
        'follow_date',
        'follow_time',
        'follow_mail_status',
        'call_back_date',
        'call_back_time',
        'quotation_amount',
        'quotation_tax',
        'quotation_discount',
        'quotation_total',
        'quotation_reference',
        'quotation_validity',
        'quotation_expiry_date',
        'quotation_terms',
        'quotation_notes',
        'about_us',
        'created_at',
        'updated_at',
        'opened_at',
        'is_pinned',
        'last_updated_by',
        'deleted_at',
    ];

    public const MAIL_STATUS = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    protected $casts = [
        'product_ids' => 'array',
        'quotation_terms' => 'array',
        'quotation_amount' => 'decimal:2',
        'quotation_tax' => 'decimal:2',
        'quotation_discount' => 'decimal:2',
        'quotation_total' => 'decimal:2',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'lead_product', 'lead_id', 'product_id')
            ->withPivot([
                'price',
                'discount',
                'tax_percentage',
                'price_after_discount',
                'tax_amount',
                'total_amount'
            ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assign()
    {
        return $this->belongsTo(User::class, 'assigned_name');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by_id');
    }

    public function lastUpdateBy()
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    public function getTotalAmountAttribute()
    {
        $subtotal = $this->quotation_amount ?? 0;
        $tax = $this->quotation_tax ?? 0;
        return $subtotal + ($subtotal * $tax / 100);
    }
}

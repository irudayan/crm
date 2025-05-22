<?php

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
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    public function products()
    {
        return $this->belongsToMany(Products::class, 'lead_product', 'lead_id', 'product_id');
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

}
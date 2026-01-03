<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegalAidProvider extends Model
{
    use HasFactory;
    protected $fillable = [
        'reg_no',
        'name',
        'licence_no',
        'approved_date',
        'licence_expiry_date',
        'region',
        'district',
        'email',
        'phone',
        'paid',
    ];

    protected $casts = [
        'approved_date' => 'date',
        'licence_expiry_date' => 'date',
        'paid' => 'boolean',
    ];

    protected $appends = [];

    public function scopeFiltered($query, array $filters)
    {
        if (! empty($filters['name'])) {
            $query->where('name', 'like', "%{$filters['name']}%");
        }
        if (! empty($filters['email'])) {
            $query->where('email', 'like', "%{$filters['email']}%");
        }

        // Region Scope
        if (isset($filters['region_scope']) && $filters['region_scope'] === 'specific' && ! empty($filters['region'])) {
            $query->where('region', $filters['region']);
        }

        // District Scope
        if (isset($filters['district_scope']) && $filters['district_scope'] === 'specific' && ! empty($filters['district'])) {
            $query->where('district', $filters['district']);
        }

        // Paid Scope
        if (isset($filters['paid_scope']) && $filters['paid_scope'] === 'specific' && isset($filters['paid'])) {
            $query->where('paid', $filters['paid']);
        } elseif (isset($filters['paid']) && !isset($filters['paid_scope'])) {
             $query->where('paid', $filters['paid']);
        }

        // Status Scope (active = approved within last 3 years)
        if (isset($filters['status']) && $filters['status'] === 'active') {
            $query->whereDate('approved_date', '>=', now()->subYears(3));
        } elseif (isset($filters['status']) && $filters['status'] === 'expired') {
            $query->where(function ($q) {
                $q->whereDate('approved_date', '<', now()->subYears(3))
                  ->orWhereNull('approved_date');
            });
        }

        // Approved Date Scope
        if (isset($filters['approved_date_scope']) && $filters['approved_date_scope'] === 'specific') {
            if (!empty($filters['approved_date_from'])) {
                $query->whereDate('approved_date', '>=', $filters['approved_date_from']);
            }
            if (!empty($filters['approved_date_to'])) {
                $query->whereDate('approved_date', '<=', $filters['approved_date_to']);
            }
        }

        // Licence Expiry Date Scope
        if (isset($filters['licence_expiry_date_scope']) && $filters['licence_expiry_date_scope'] === 'specific') {
            if (!empty($filters['licence_expiry_date_from'])) {
                $query->whereDate('licence_expiry_date', '>=', $filters['licence_expiry_date_from']);
            }
            if (!empty($filters['licence_expiry_date_to'])) {
                $query->whereDate('licence_expiry_date', '<=', $filters['licence_expiry_date_to']);
            }
        }

        return $query;
    }

    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }
}

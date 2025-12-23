<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['title', 'filters', 'columns'];

    protected $casts = [
        'filters' => 'array',
        'columns' => 'array',
    ];

    public function legalAidProviders()
    {
        return $this->belongsToMany(LegalAidProvider::class);
    }

    public function getProvidersAttribute()
    {
        // Cache the query result for 5 minutes
        $cacheKey = 'report_' . $this->id . '_providers_' . md5(json_encode($this->filters));
        
        return cache()->remember($cacheKey, 300, function () {
            $query = LegalAidProvider::query();

            // Only select needed columns if filters specify them
            if (!empty($this->columns)) {
                $query->select(array_merge(['id'], $this->columns));
            }

            if ($filters = $this->filters) {
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
                     // Fallback for old reports or if scope is missing but paid is set (though form handles it)
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
            }

            return $query->get();
        });
    }
}

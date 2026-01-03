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
                $query->filtered($filters);
            }

            return $query->get();
        });
    }
}

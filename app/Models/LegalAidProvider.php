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

    protected $appends = ['status'];

    public function getStatusAttribute(): string
    {
        if (! $this->approved_date) {
            return 'expired';
        }

        $approved = Carbon::parse($this->approved_date);

        return $approved->greaterThanOrEqualTo(now()->subYears(3)) ? 'active' : 'expired';
    }
    public function reports()
    {
        return $this->belongsToMany(Report::class);
    }
}

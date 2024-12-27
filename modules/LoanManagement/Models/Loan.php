<?php

namespace Modules\LoanManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_id',
        'loan_amount',
        'interest_rate',
        'repayment_duration_months',
        'status',
        'created_by',
        'updated_by',
    ];

    // Relationships
    public function farmer()
    {
        return $this->belongsTo(\Modules\FarmerManagement\Models\Farmer::class);
    }

    public function changes()
    {
        return $this->hasMany(LoanChange::class);
    }
}

<?php

namespace Modules\LoanManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'changed_by',
        'change_description',
    ];

    // Relationships
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'changed_by');
    }
}

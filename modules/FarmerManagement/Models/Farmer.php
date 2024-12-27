<?php

namespace Modules\FarmerManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'nrcs_number',
        'date_of_birth',
        'country',
        'city',
        'address',
        'next_of_kin',
        'email',
        'type_of_farm',
        'category',
        'land_area',
        'nrc_passport_file',
        'bank_statement',
        'other_documents',
        'status', // Add status to the fillable fields
    ];

    /**
     * The attributes that should have default values.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'pending', // Default value for the status field
    ];
}

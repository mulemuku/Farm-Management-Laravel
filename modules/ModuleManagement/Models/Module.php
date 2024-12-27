<?php

namespace Modules\ModuleManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    // Specify the table if not using default naming conventions
    protected $table = 'modules';

    // Define the fillable attributes for mass assignment
    protected $fillable = ['name', 'path', 'description', 'is_active', 'has_database_cleanup'];

    /**
     * Accessor for `is_active` attribute.
     * Converts the boolean to a human-readable string.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->is_active ? 'active' : 'inactive';
    }

    /**
     * Mutator for `is_active` attribute.
     * Allows setting the active status using 'active' or 'inactive'.
     *
     * @param string $value
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['is_active'] = strtolower($value) === 'active' ? 1 : 0;
    }
}

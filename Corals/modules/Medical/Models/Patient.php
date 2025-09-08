<?php

namespace Corals\Modules\Medical\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Modules\Medical\Enums\GenderStatus;
use Corals\Modules\Medical\Enums\MaritalStatus;
use Spatie\Activitylog\Traits\LogsActivity;

class Patient extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'medical.models.patient';

    protected $casts = [
        'properties' => 'json',
        'date_of_birth' => 'date',
        'gender' => GenderStatus::class,
        'marital' => MaritalStatus::class,
    ];

    protected $table = 'medical_patients';

    protected $guarded = ['id'];

    /**
     * Relationship with city
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relationship with village
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Get age from date of birth
     */
    public function getAgeFromDateAttribute()
    {
        if ($this->date_of_birth) {
            return $this->date_of_birth->age;
        }
        return $this->age;
    }

    /**
     * Get full address
     */
    public function getFullAddressAttribute()
    {
        $address = [];
        if ($this->village) {
            $address[] = $this->village->name;
        }
        if ($this->city) {
            $address[] = $this->city->name;
        }
        return implode(', ', $address);
    }
}

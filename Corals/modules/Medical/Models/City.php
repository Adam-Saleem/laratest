<?php

namespace Corals\Modules\Medical\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class City extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'medical.models.city';

    protected $casts = [
        'properties' => 'json',
    ];

    protected $table = 'medical_cities';

    protected $guarded = ['id'];

    /**
     * Relationship with villages
     */
    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
<?php

namespace Corals\Modules\Medical\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Village extends BaseModel
{
    use PresentableTrait;
    use LogsActivity;

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'medical.models.village';

    protected $casts = [
        'properties' => 'json',
    ];

    protected $table = 'medical_villages';

    protected $guarded = ['id'];

    /**
     * Relationship with city
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
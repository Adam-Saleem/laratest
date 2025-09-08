<?php

return [
    'models' => [
        'patient' => [
            'presenter' => \Corals\Modules\Medical\Transformers\PatientPresenter::class,
            'resource_url' => 'medical/patients',
        ],
        'city' => [
            'presenter' => \Corals\Modules\Medical\Transformers\CityPresenter::class,
            'resource_url' => 'medical/cities',
        ],
        'village' => [
            'presenter' => \Corals\Modules\Medical\Transformers\VillagePresenter::class,
            'resource_url' => 'medical/villages',
        ],
    ],
    'active_theme' => 'corals-elite-admin',
];

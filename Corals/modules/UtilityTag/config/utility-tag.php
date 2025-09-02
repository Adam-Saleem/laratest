<?php

return [
    'models' => [
        'tag' => [
            'presenter' => \Corals\Modules\UtilityTag\Transformers\TagPresenter::class,
            'resource_url' => 'utilities/tags',
            'translatable' => ['name'],
        ],
    ],
];

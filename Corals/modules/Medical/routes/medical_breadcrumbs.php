<?php

//Patient
Breadcrumbs::register('medical_patients', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Medical::module.patient.title'), url(config('medical.models.patient.resource_url')));
});

Breadcrumbs::register('medical_patient_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('medical_patients');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('medical_patient_show', function ($breadcrumbs) {
    $breadcrumbs->parent('medical_patients');
    $breadcrumbs->push(view()->shared('title_singular'));
});

//City
Breadcrumbs::register('medical_cities', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Medical::module.city.title'), url(config('medical.models.city.resource_url')));
});

Breadcrumbs::register('medical_city_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('medical_cities');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('medical_city_show', function ($breadcrumbs) {
    $breadcrumbs->parent('medical_cities');
    $breadcrumbs->push(view()->shared('title_singular'));
});

//Village
Breadcrumbs::register('medical_villages', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(trans('Medical::module.village.title'), url(config('medical.models.village.resource_url')));
});

Breadcrumbs::register('medical_village_create_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('medical_villages');
    $breadcrumbs->push(view()->shared('title_singular'));
});

Breadcrumbs::register('medical_village_show', function ($breadcrumbs) {
    $breadcrumbs->parent('medical_villages');
    $breadcrumbs->push(view()->shared('title_singular'));
});
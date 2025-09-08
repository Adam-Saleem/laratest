<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'medical', 'as' => 'medical.'], function () {
    Route::resource('patients', 'PatientsController');
    Route::resource('cities', 'CitiesController');
    Route::resource('villages', 'VillagesController');
});

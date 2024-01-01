<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Team
    Route::post('teams/media', 'TeamApiController@storeMedia')->name('teams.storeMedia');
    Route::apiResource('teams', 'TeamApiController');

    // Benefit Category
    Route::apiResource('benefit-categories', 'BenefitCategoryApiController');

    // Benefit
    Route::post('benefits/media', 'BenefitApiController@storeMedia')->name('benefits.storeMedia');
    Route::apiResource('benefits', 'BenefitApiController');

    // Employee
    Route::post('employees/media', 'EmployeeApiController@storeMedia')->name('employees.storeMedia');
    Route::apiResource('employees', 'EmployeeApiController');

    // Province
    Route::apiResource('provinces', 'ProvinceApiController');

    // Variant
    Route::apiResource('variants', 'VariantApiController');
});

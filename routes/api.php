<?php
Route::get('getBenefitCategory', 'Api\V1\Admin\BenefitCategoryApiController@index');
Route::get('getBenefit/{cat_id}', 'Api\V1\Admin\BenefitApiController@index');
Route::get('getBenefitVariant/{benefit_id}', 'Api\V1\Admin\BenefitVariantApiController@index');

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::apiResource('users', 'UsersApiController');

    // Team
    Route::post('teams/media', 'TeamApiController@storeMedia')->name('teams.storeMedia');
    Route::apiResource('teams', 'TeamApiController');

    // Benefit Category
    Route::apiResource('benefit-categories', 'BenefitCategoryApiController');

    // Benefit Variant
    Route::post('benefit-variants/media', 'BenefitVariantApiController@storeMedia')->name('benefit-variants.storeMedia');
    Route::apiResource('benefit-variants', 'BenefitVariantApiController');

    // Benefit
    Route::post('benefits/media', 'BenefitApiController@storeMedia')->name('benefits.storeMedia');
    Route::apiResource('benefits', 'BenefitApiController');

    // Employee
    Route::post('employees/media', 'EmployeeApiController@storeMedia')->name('employees.storeMedia');
    Route::apiResource('employees', 'EmployeeApiController');

    // Benefit Package
    Route::post('benefit-packages/media', 'BenefitPackageApiController@storeMedia')->name('benefit-packages.storeMedia');
    Route::apiResource('benefit-packages', 'BenefitPackageApiController');

    // User Alerts
    Route::apiResource('user-alerts', 'UserAlertsApiController');

    // Benefit Company
    Route::apiResource('benefit-companies', 'BenefitCompanyApiController');
});

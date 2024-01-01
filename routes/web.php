<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Team
    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::post('teams/media', 'TeamController@storeMedia')->name('teams.storeMedia');
    Route::post('teams/ckmedia', 'TeamController@storeCKEditorImages')->name('teams.storeCKEditorImages');
    Route::post('teams/parse-csv-import', 'TeamController@parseCsvImport')->name('teams.parseCsvImport');
    Route::post('teams/process-csv-import', 'TeamController@processCsvImport')->name('teams.processCsvImport');
    Route::resource('teams', 'TeamController');

    // Benefit Category
    Route::delete('benefit-categories/destroy', 'BenefitCategoryController@massDestroy')->name('benefit-categories.massDestroy');
    Route::post('benefit-categories/parse-csv-import', 'BenefitCategoryController@parseCsvImport')->name('benefit-categories.parseCsvImport');
    Route::post('benefit-categories/process-csv-import', 'BenefitCategoryController@processCsvImport')->name('benefit-categories.processCsvImport');
    Route::resource('benefit-categories', 'BenefitCategoryController');

    // Benefit Variant
    Route::delete('benefit-variants/destroy', 'BenefitVariantController@massDestroy')->name('benefit-variants.massDestroy');
    Route::post('benefit-variants/media', 'BenefitVariantController@storeMedia')->name('benefit-variants.storeMedia');
    Route::post('benefit-variants/ckmedia', 'BenefitVariantController@storeCKEditorImages')->name('benefit-variants.storeCKEditorImages');
    Route::resource('benefit-variants', 'BenefitVariantController');

    // Benefit
    Route::delete('benefits/destroy', 'BenefitController@massDestroy')->name('benefits.massDestroy');
    Route::post('benefits/media', 'BenefitController@storeMedia')->name('benefits.storeMedia');
    Route::post('benefits/ckmedia', 'BenefitController@storeCKEditorImages')->name('benefits.storeCKEditorImages');
    Route::post('benefits/parse-csv-import', 'BenefitController@parseCsvImport')->name('benefits.parseCsvImport');
    Route::post('benefits/process-csv-import', 'BenefitController@processCsvImport')->name('benefits.processCsvImport');
    Route::resource('benefits', 'BenefitController');

    // Employee
    Route::delete('employees/destroy', 'EmployeeController@massDestroy')->name('employees.massDestroy');
    Route::post('employees/media', 'EmployeeController@storeMedia')->name('employees.storeMedia');
    Route::post('employees/ckmedia', 'EmployeeController@storeCKEditorImages')->name('employees.storeCKEditorImages');
    Route::post('employees/parse-csv-import', 'EmployeeController@parseCsvImport')->name('employees.parseCsvImport');
    Route::post('employees/process-csv-import', 'EmployeeController@processCsvImport')->name('employees.processCsvImport');
    Route::resource('employees', 'EmployeeController');

    // Benefit Package
    Route::delete('benefit-packages/destroy', 'BenefitPackageController@massDestroy')->name('benefit-packages.massDestroy');
    Route::post('benefit-packages/media', 'BenefitPackageController@storeMedia')->name('benefit-packages.storeMedia');
    Route::post('benefit-packages/ckmedia', 'BenefitPackageController@storeCKEditorImages')->name('benefit-packages.storeCKEditorImages');
    Route::post('benefit-packages/parse-csv-import', 'BenefitPackageController@parseCsvImport')->name('benefit-packages.parseCsvImport');
    Route::post('benefit-packages/process-csv-import', 'BenefitPackageController@processCsvImport')->name('benefit-packages.processCsvImport');
    Route::resource('benefit-packages', 'BenefitPackageController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController');

    // Benefit Company
    Route::delete('benefit-companies/destroy', 'BenefitCompanyController@massDestroy')->name('benefit-companies.massDestroy');
    Route::post('benefit-companies/parse-csv-import', 'BenefitCompanyController@parseCsvImport')->name('benefit-companies.parseCsvImport');
    Route::post('benefit-companies/process-csv-import', 'BenefitCompanyController@processCsvImport')->name('benefit-companies.processCsvImport');
    Route::resource('benefit-companies', 'BenefitCompanyController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
    Route::get('team-members', 'TeamMembersController@index')->name('team-members.index');
    Route::post('team-members', 'TeamMembersController@invite')->name('team-members.invite');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

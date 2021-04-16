<?php

Route::group(['namespace' => 'TNM\USSD\Http', 'prefix' => 'api/ussd'], function () {
    Route::post('/hubtel',['uses' => 'Controller']);
    Route::post('/{adapter?}', ['uses' => 'Controller']);
});


<?php

Route::group(['namespace' => 'Faakolore\USSD\Http', 'prefix' => 'api/ussd'], function () {
    Route::post('/{adapter?}', ['uses' => 'Controller']);
});


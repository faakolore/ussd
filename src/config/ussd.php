<?php

return [
    'session' => [
        'last_activity_minutes' => env('LAST_SESSION_ACTIVITY_MINUTES', 2)
    ],
    'hubtel_client_id' => env('HUBTEL_CLIENT_ID',null),

    'hubtel_client_secret' => env('HUBTEL_CLIENT_SECRET',null),

    'nalo_user_id' => env('NALO_USERID','NALOTest'),

    //Available Adapters
    // set the adapter the ussd gateway you are using
    // nalo, hubtel, flares, truRoute
    'adapter'=> env('USSD_ADAPTER',null)
];

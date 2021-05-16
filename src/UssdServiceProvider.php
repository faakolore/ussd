<?php

namespace Faakolore\USSD;

use Faakolore\USSD\Commands\MakeUssdAdapter;
use Illuminate\Support\ServiceProvider as Provider;
use Faakolore\USSD\Commands\AuditSession;
use Faakolore\USSD\Commands\CleanUp;
use Faakolore\USSD\Commands\Install;
use Faakolore\USSD\Commands\ListUserTransactions;
use Faakolore\USSD\Commands\MakeScreenFactory;
use Faakolore\USSD\Commands\MakeUssd;
use Faakolore\USSD\Commands\MonitorPayload;
use Faakolore\USSD\Commands\Update;
use Faakolore\USSD\Models\Payload;
use Faakolore\USSD\Models\Session;
use Faakolore\USSD\Models\SessionNumber;
use Faakolore\USSD\Models\TransactionTrail;
use Faakolore\USSD\Observers\PayloadObserver;
use Faakolore\USSD\Observers\SessionNumberObserver;
use Faakolore\USSD\Observers\SessionObserver;
use Faakolore\USSD\Observers\TransactionTrailObserver;

class UssdServiceProvider extends Provider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/translations', 'ussd');

//        $this->publishes([
//            __DIR__.'/database/migrations/' => database_path('migrations')
//        ]);

        $this->publishes([
            __DIR__ . '/translations' => resource_path('lang/vendor/ussd'),
        ]);

        $this->publishes([
            __DIR__ . '/config/ussd.php' => config_path('ussd.php'),
        ]);


        Payload::observe(PayloadObserver::class);
        TransactionTrail::observe(TransactionTrailObserver::class);
        Session::observe(SessionObserver::class);
        SessionNumber::observe(SessionNumberObserver::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/ussd.php', 'ussd'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeUssd::class,
                Install::class,
                MakeScreenFactory::class,
                CleanUp::class,
                AuditSession::class,
                ListUserTransactions::class,
                MonitorPayload::class,
                Update::class,
                MakeUssdAdapter::class,
            ]);
        }
    }
}

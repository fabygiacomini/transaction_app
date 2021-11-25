<?php

namespace App\Providers;

use App\Modules\Transaction\Repository\EloquentTransactionRepository;
use App\Modules\Transaction\Repository\TransactionRepositoryInterface;
use App\Modules\TransactionAuthorization\Repository\TransactionAuthorizerRepositoryInterface;
use App\Modules\TransactionAuthorizer\Repository\ACMETransactionAuthorizerRepository;
use App\Modules\User\Repository\EloquentUserRepository;
use App\Modules\User\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Binding the Repository Interface with the Concrete Repository Class
        // In this case, only one Implementation exists
        $this->app->bind(
            TransactionRepositoryInterface::class,
            EloquentTransactionRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

        $this->app->bind(
            TransactionAuthorizerRepositoryInterface::class,
            ACMETransactionAuthorizerRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

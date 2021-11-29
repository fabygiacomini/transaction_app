<?php

namespace App\Providers;

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionControllerInterface;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserControllerInterface;
use App\Modules\Transaction\Repository\TransactionRepositoryInterface;
use App\Modules\Transaction\Service\TransactionService;
use App\Modules\Transaction\Service\TransactionServiceInterface;
use App\Modules\Transaction\Validation\ProcessValidations;
use App\Modules\Transaction\Validation\ProcessValidationsInterface;
use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerService;
use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\Service\UserService;
use App\Modules\User\Service\UserServiceInterface;
use App\Modules\Wallet\Service\WalletService;
use App\Modules\Wallet\Service\WalletServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Binding the Service Interface with the Concrete Service Class
        // In this case, only one Implementation exists

        /* Services */
        $this->app->bind(
            TransactionServiceInterface::class,
            TransactionService::class
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );

        $this->app->bind(
            TransactionAuthorizerServiceInterface::class,
            TransactionAuthorizerService::class
        );

        $this->app->bind(
            WalletServiceInterface::class,
            WalletService::class
        );

        /* Validations */
        $this->app->bind(
            ProcessValidationsInterface::class,
            ProcessValidations::class
        );

        /* Controllers */
        $this->app->bind(
            TransactionControllerInterface::class,
            TransactionController::class
        );

        $this->app->bind(
            UserControllerInterface::class,
            UserController::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

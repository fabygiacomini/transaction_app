<?php


namespace Tests\Unit;


use App\Exceptions\TransactionException;
use App\Modules\Transaction\Repository\EloquentTransactionRepository;
use App\Modules\Transaction\Repository\TransactionRepositoryInterface;
use App\Modules\Transaction\Service\TransactionService;
use App\Modules\Transaction\TransactionEntity;
use App\Modules\Transaction\Validation\ProcessValidations;
use App\Modules\Transaction\Validation\ProcessValidationsInterface;
use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerService;
use App\Modules\TransactionAuthorizer\Service\TransactionAuthorizerServiceInterface;
use App\Modules\User\Service\UserService;
use App\Modules\User\Service\UserServiceInterface;
use App\Modules\User\UserEntity;
use App\Modules\Wallet\Service\WalletService;
use App\Modules\Wallet\Service\WalletServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var TransactionAuthorizerServiceInterface
     */
    private $authorizerService;

    /**
     * @var ProcessValidationsInterface
     */
    private $processValidations;

    /**
     * @var WalletServiceInterface
     */
    private $walletService;

    /**
     * @var TransactionService
     */
    private $transactionService;

    public function setUp(): void
    {
        parent::setUp();

        // Mocking the TransactionService's dependencies
        $this->transactionRepository = \Mockery::mock(EloquentTransactionRepository::class);
        $this->app->instance(TransactionRepositoryInterface::class, $this->transactionRepository);

        $this->userService = \Mockery::mock(UserService::class);
        $this->app->instance(UserServiceInterface::class, $this->userService);

        $this->authorizerService = \Mockery::mock(TransactionAuthorizerService::class);
        $this->app->instance(TransactionAuthorizerServiceInterface::class, $this->authorizerService);

        $this->processValidations = \Mockery::mock(ProcessValidations::class);
        $this->app->instance(ProcessValidationsInterface::class, $this->processValidations);

        $this->walletService = \Mockery::mock(WalletService::class);
        $this->app->instance(WalletServiceInterface::class, $this->walletService);

        // Transaction Service
        $this->transactionService = $this->app->make(TransactionService::class);

        Mail::fake();
    }

    /**
     * Tests the successful creation of a new transaction
     */
    public function testCreateNewTransactionWithSuccess()
    {
        $payer = new UserEntity();
        $payee = new userEntity();
        $value = 340.89;

        $this->userService->shouldReceive('getUserAndWallet')
            ->with(1)
            ->andReturn($payer);

        $this->userService->shouldReceive('getUserAndWallet')
            ->with(2)
            ->andReturn($payee);

        $this->processValidations->shouldReceive('validateTransaction')
            ->with($payer, $payee, $value, $this->authorizerService)
            ->andReturn(true); // passed validations

        $this->walletService->shouldReceive('withdraw')
            ->once()
            ->with($payer, $value);

        $this->walletService->shouldReceive('deposit')
            ->once()
            ->with($payee, $value);

        $transactionEntity = new TransactionEntity();
        $this->transactionRepository->shouldReceive('newTransaction')
            ->once()
            ->with($payer, $payee, $value)
            ->andReturn($transactionEntity);

        $transaction = $this->transactionService->makeTransaction(1, 2, $value);

        $this->assertEquals($transaction, $transactionEntity);
    }

    /**
     * Test create transaction, but with failed return on previous validations
     */
    public function testTransactionProcessValidationFailedReturnException()
    {
        $this->expectException(TransactionException::class);
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);

        $payer = new UserEntity();
        $payee = new userEntity();
        $value = 340.89;

        $this->userService->shouldReceive('getUserAndWallet')
            ->with(1)
            ->andReturn($payer);

        $this->userService->shouldReceive('getUserAndWallet')
            ->with(2)
            ->andReturn($payee);

        $this->processValidations->shouldReceive('validateTransaction')
            ->andReturn(false); // failed validation

        $this->transactionService->makeTransaction(1, 2, $value);
    }

    /**
     * Test the send notification method when the payee user's wallet
     * is not found
     */
    public function testSendNotificationPayeeNotFound()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Usuário não encontrado!');
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);

        $payee = null; // user not found
        $this->userService->shouldReceive('getUserAndWallet')
            ->with(2)
            ->andReturn($payee);

        $transaction = new TransactionEntity();
        $transaction->setPayeeId(2);

        $this->transactionService->notifyTransactionPayee($transaction);
    }
}

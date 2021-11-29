<?php

namespace App\Http\Controllers;

use App\Exceptions\TransactionException;
use App\Http\Requests\TransactionRequest;
use App\Modules\Transaction\Service\TransactionServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller implements TransactionControllerInterface
{

    /**
     * @var TransactionServiceInterface
     */
    private $transactionService;

    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        try {
            return response($this->transactionService->getTransactions(), Response::HTTP_OK);

        } catch (\Exception $exception) {
            return response(['message' => 'Não foi possível recuperar as transações.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @return Response
     */
    public function store(TransactionRequest $request): Response
    {
        try {
            DB::beginTransaction();

            $transaction = $this->transactionService->makeTransaction(
                $request->get('payer_id'),
                $request->get('payee_id'),
                $request->get('value')
            );

            DB::commit();

        } catch (TransactionException $exception) {

            DB::rollBack();

            return response(['message' => $exception->getMessage()], $exception->getCode());
        }

        $successMessage = "Transação realizada com sucesso! ID: " . $transaction->getId() . ". ";

        try {
            $this->transactionService->notifyTransactionPayee($transaction);

            $successMessage .= 'Notificação da transação enviada ao beneficiário.';

        } catch (\Exception $exception) {
            $successMessage .= 'No entanto, não foi possível enviar uma notificação ao usuário.';
        }

        return response(['message' => $successMessage], Response::HTTP_CREATED);
    }
}

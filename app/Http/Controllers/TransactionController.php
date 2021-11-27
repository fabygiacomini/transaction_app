<?php

namespace App\Http\Controllers;

use App\Exceptions\TransactionException;
use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Modules\Transaction\Service\TransactionServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response($this->transactionService->getTransactions(), 200);

        } catch (\Exception $exception) {
            return response(['message' => 'Não foi possível recuperar as transações.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        try {
            DB::beginTransaction();

            $transaction = $this->transactionService->create(
                $request->get('payer_id'),
                $request->get('payee_id'),
                $request->get('value')
            );

            DB::commit();

        } catch (TransactionException $exception) {

            DB::rollBack();

            return response(['message' => $exception->getMessage()], $exception->getCode());
        }

        $sucessMessage = "Transação realizada com sucesso! ID: " . $transaction->getId();

        // mandar mensagem, dependendo se der certo, retornar uma mensagem diferente ao usuário
        try {

        } catch (\Exception $exception) {
            $sucessMessage .= ' No entanto, não foi possível enviar uma notificação ao usuário.';
        }

        return response(['message' => $sucessMessage], Response::HTTP_CREATED);
    }
}

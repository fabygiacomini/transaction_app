<?php


namespace App\Http\Controllers;


use App\Http\Requests\TransactionRequest;
use App\Modules\Transaction\Service\TransactionServiceInterface;
use Illuminate\Http\Response;

interface TransactionControllerInterface
{
    /**
     * TransactionControllerInterface constructor.
     * @param TransactionServiceInterface $transactionService
     */
    public function __construct(TransactionServiceInterface $transactionService);

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response;

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @return Response
     */
    public function store(TransactionRequest $request): Response;
}

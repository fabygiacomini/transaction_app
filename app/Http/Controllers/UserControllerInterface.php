<?php


namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Modules\User\Service\UserServiceInterface;
use Illuminate\Http\Response;

interface UserControllerInterface
{
    /**
     * UserControllerInterface constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService);

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response;

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response;

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request): Response;

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function update(UserRequest $request): Response;

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userId
     * @return Response
     */
    public function destroy(int $userId): Response;
}

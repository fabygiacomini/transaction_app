<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Modules\User\Service\UserServiceInterface;
use App\Modules\User\UserEntity;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        try {
            return response($this->userService->getUsers(), Response::HTTP_OK);

        } catch (\Exception $exception) {
            return response(['message' => 'Não foi possível recuperar os usuários cadastrados.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        try {
            return response($this->userService->findUser($id), Response::HTTP_OK);

        } catch (\Exception $exception) {
            return response(['message' => 'Não foi possível encontrar o usuário informado.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request): Response
    {
        try {
            DB::beginTransaction();

            $user = new UserEntity();
            $user->setName($request->input('name'));
            $user->setEmail($request->input('email'));
            $user->setPassword($request->input('password'));
            $user->setCpfCnpj($request->input('cpf_cnpj'));
            $user->setShopkeeper($request->input('shopkeeper'));

            $createdUser = $this->userService->createNewUser($user);

            DB::commit();
            return response(['message' => 'Novo usuário criado com sucesso! ID: '. $createdUser->getId()], Response::HTTP_CREATED);

        } catch (UserException $userException) {
            DB::rollBack();
            return response(['message' => $userException->getMessage()], $userException->getCode());

        } catch (\Exception $exception) {
            DB::rollBack();
            return response(['message' => 'Não foi possível criar o usuário.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function update(UserRequest $request): Response
    {
        try {
            $user = new UserEntity();
            $user->setId($request->input('id'));
            $user->setName($request->input('name'));
            $user->setEmail($request->input('email'));
            $user->setPassword($request->input('password'));
            $user->setCpfCnpj($request->input('cpf_cnpj'));
            $user->setShopkeeper($request->input('shopkeeper'));

            $createdUser = $this->userService->updateUser($user);

            return response(['message' => 'Usuário atualizado com sucesso! ID: ' . $createdUser->getId()], Response::HTTP_CREATED);

        } catch (UserException $userException) {
            return response(['message' => $userException->getMessage()], $userException->getCode());

        } catch (\Exception $exception) {
            return response(['message' => 'Não foi possível criar o usuário.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userId
     * @return Response
     */
    public function destroy(int $userId): Response
    {
        try {
            $this->userService->deleteUser($userId);
            return response(['message' => 'Usuário removido com sucesso!'], Response::HTTP_OK);

        } catch (UserException $userException) {
            return response(['message' => $userException->getMessage()], $userException->getCode());

        } catch (\Exception $exception) {
            return response(['message' => 'Ocorreu um erro ao tentar remover o usuário.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

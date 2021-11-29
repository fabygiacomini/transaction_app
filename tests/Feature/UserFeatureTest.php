<?php


namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test insert new user and return status code 201 (created).
     */
    public function testShouldCreateNewUserAndReturnHttpStatus201()
    {
        $payload = [
            'name' => 'Darwin G',
            'email' => 'd@email.com',
            'cpf_cnpj' => 999999999,
            'shopkeeper' => 0,
            'password' => md5('1234')
        ];

        $this->post('/api/user', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['message']);
    }

    /**
     * Test should failed on request validation on using cpf already present on database.
     */
    public function testShouldFailOnValidationOfNewUserWithSameCpf()
    {
        $payload = [
            'name' => 'Darwin G',
            'email' => 'd@email.com',
            'cpf_cnpj' => 12345678900,
            'shopkeeper' => 0,
            'password' => md5('1234')
        ];

        $response = $this->post('/api/user', $payload, ['X-Requested-With' => 'XMLHttpRequest']);
        $response->assertSessionHasErrors(['cpf_cnpj']);
    }

    /**
     * Test that list every user found.
     * If UserSeeder was seeded, than an specific user can be asserted.
     */
    public function testShouldListAllUsersReturnHttpStatus200()
    {
        $this->get('/api/user')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([ // same register in UserSeeder
                'cpf_cnpj' => 12345678900,
                'email' => 'fabiana@email.com',
                'id' => 1,
                'name' => 'Fabiana G',
                'shopkeeper' => 0
            ]);
    }

    /**
     * Test searching for one specific user.
     */
    public function testShouldFindAndShowUserAndReturnHttpStatus200()
    {
        $this->get('/api/user/1')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([ // same register in UserSeeder
                'cpf_cnpj' => 12345678900,
                'email' => 'fabiana@email.com',
                'name' => 'Fabiana G',
                'shopkeeper' => 0
            ]);
    }

    public function testShouldDeleteUser()
    {
        $users = User::factory(1)->create();

        $this->delete('/api/user/'.$users->first()->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'message' => 'Usuário removido com sucesso!'
            ]);
    }
}

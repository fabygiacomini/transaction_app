<?php


namespace Tests\Feature;


use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class TransactionFeatureTest extends TestCase
{
    use DatabaseTransactions; // reset database after tests

    /**
     * Test the creation of a new transaction and should return
     * HTTP Status Code 201 (created)
     */
    public function testShouldCreateNewTransactionAndReturnHttpStatus201()
    {
        // Users 1 and 2 created by UserSeeder
        $payload = [
            'payer_id' => 1,
            'payee_id' => 2,
            'value' => 120.79
        ];

        $this->post('/api/transaction', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(['message']);

        $this->assertDatabaseCount('transactions', 1);
    }

    /**
     * Test should return HTTP Status Code 401,
     * because the payer user is a shopkeeper (can not make payments).
     */
    public function testShouldReturnHttpStatus401()
    {
        $payload = [
            'payer_id' => 2, // shopkeeper
            'payee_id' => 1,
            'value' => 120.79
        ];

        $this->post('/api/transaction', $payload)
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure(['message']);
    }

    /**
     * Test should failed on request validations, because 'player_id'
     * don't exists on database.
     */
    public function testShouldFailedValidationPayerIdNotExists()
    {
        $payload = [
            'payer_id' => 88,
            'payee_id' => 1,
            'value' => 120.79
        ];

        $response = $this->post('/api/transaction', $payload, ['X-Requested-With' => 'XMLHttpRequest']);
        $response->assertSessionHasErrors(['payer_id']);
    }

    /**
     * Test listing the transactions created
     */
    public function testShouldListAllTransactions()
    {
        Transaction::factory()->count(5)->create();

        $this->get('/api/transaction')
            ->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseCount('transactions', 5);
    }
}

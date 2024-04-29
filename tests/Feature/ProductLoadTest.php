<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductLoadTest extends TestCase
{
    /**
     * Testa a capacidade da rota getProduct de lidar com um grande volume de solicitações.
     *
     * @return void
     */
    public function testProductLoadHandling()
    {
        // Defina o número de solicitações que você deseja enviar
        $requestCount = 100;

        // Envie várias solicitações HTTP para a rota getProduct
        // Use um loop para enviar várias solicitações em sequência
        for ($i = 0; $i < $requestCount; $i++) {
            $response = $this->get('/getProduct');

            // Verifique se a resposta é bem-sucedida (código de status 200)
            $response->assertStatus(Response::HTTP_OK);
        }
    }
}

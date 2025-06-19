<?php

namespace App\Tests\Unit\Api\Cart\Infraestructure;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartFlowTest extends WebTestCase
{
    public function testFullNormalFlow(): void
    {
        $client = static::createClient();

        // 1: Crear carrito
        $client->request('POST', '/api/cart');
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('cart', $responseData);

        $cartId = $responseData['cart']['id'] ?? null;
        $this->assertNotNull($cartId);

        // 2: Añadir ítem
        $client->request('POST', '/api/cart/items', [], [], [
            'HTTP_X_CART_ID' => $cartId,
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'product_id' => 12,
            'quantity' => 2,
        ]));
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('cart', $responseData);
        $this->assertSame($cartId, $responseData['cart']['id'] ?? null);

        // 3: Obtener carrito
        $client->request('GET', '/api/cart', [], [], [
            'HTTP_X_CART_ID' => $cartId,
            'CONTENT_TYPE' => 'application/json',
        ]);
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('cart', $responseData);
        $this->assertSame($cartId, $responseData['cart']['id'] ?? null);
        $this->assertCount(1, $responseData['cart']['items']);

        // 3: Añadir ítem
        $client->request('POST', '/api/cart/items', [], [], [
            'HTTP_X_CART_ID' => $cartId,
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'product_id' => 24,
            'quantity' => 1,
        ]));
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('cart', $responseData);
        $this->assertSame($cartId, $responseData['cart']['id'] ?? null);
        $this->assertCount(2, $responseData['cart']['items']);

        // 4: Vaciar carrito
        $client->request('DELETE', '/api/cart', [], [], [
            'HTTP_X_CART_ID' => $cartId,
            'CONTENT_TYPE' => 'application/json',
        ]);
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('cart', $responseData);
        $this->assertSame($cartId, $responseData['cart']['id'] ?? null);
        $this->assertCount(0, $responseData['cart']['items']);

        // 5: Añadir ítem
        $client->request('POST', '/api/cart/items', [], [], [
            'HTTP_X_CART_ID' => $cartId,
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'product_id' => 24,
            'quantity' => 1,
        ]));
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('cart', $responseData);
        $this->assertSame($cartId, $responseData['cart']['id'] ?? null);
        $this->assertCount(1, $responseData['cart']['items']);

        // 6: Añadir ítem
        $client->request('POST', '/api/cart/items', [], [], [
            'HTTP_X_CART_ID' => $cartId,
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'product_id' => 12,
            'quantity' => 2,
        ]));
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('cart', $responseData);
        $this->assertSame($cartId, $responseData['cart']['id'] ?? null);
        $this->assertCount(2, $responseData['cart']['items']);

        // 7: Añadir nueva cantidad ítem
        $client->request('PATCH', '/api/cart/items/24', [], [], [
            'HTTP_X_CART_ID' => $cartId,
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'quantity' => 10,
        ]));
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('cart', $responseData);
        $this->assertSame($cartId, $responseData['cart']['id'] ?? null);
        $this->assertCount(2, $responseData['cart']['items']);

        foreach ($responseData['cart']['items'] as $item) {
            if ($item['product_id'] == 24) {
                $quantity = $item['quantity'];
            }
        }
        $this->assertEquals(10, $quantity ?? null);

        // 8: Borrar ítem
        $client->request('DELETE', '/api/cart/items/24', [], [], [
            'HTTP_X_CART_ID' => $cartId,
            'CONTENT_TYPE' => 'application/json',
        ]);
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('cart', $responseData);
        $this->assertSame($cartId, $responseData['cart']['id'] ?? null);
        $this->assertCount(1, $responseData['cart']['items']);

        foreach ($responseData['cart']['items'] as $item) {
            if ($item['product_id'] == 24) {
                $this->assertTrue(false);
            }
        }

    }
}

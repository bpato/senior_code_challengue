<?php

namespace App\Tests\Unit\Api\Checkout\Infraestructure;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CheckoutFlowTest extends WebTestCase
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

        // 4: Formalizar Pedido
        $client->request('POST', '/api/checkout', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'cart_id' => $cartId,
            'email' => "test@example.com",
        ]));
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('order', $responseData);

        $orderId = $responseData['order']['id'] ?? null;
        $this->assertNotNull($cartId);

        $this->assertSame($cartId, $responseData['order']['cart_reference'] ?? null);
        $this->assertCount(2, $responseData['order']['products'] ?? []);


        // 4: Ver Pedido
        $client->request('GET', '/api/order/' . $orderId , [], [], [
            'CONTENT_TYPE' => 'application/json',
        ]);
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('order', $responseData);

        $this->assertSame($orderId, $responseData['order']['id'] ?? null);
        $this->assertSame($cartId, $responseData['order']['cart_reference'] ?? null);
        $this->assertCount(2, $responseData['order']['products'] ?? []);

        // 3: Obtener carrito
        $client->request('GET', '/api/cart', [], [], [
            'HTTP_X_CART_ID' => $cartId,
            'CONTENT_TYPE' => 'application/json',
        ]);
        $this->assertResponseStatusCodeSame(404);

    }
}

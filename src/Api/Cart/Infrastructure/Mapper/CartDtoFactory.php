<?php

namespace App\Api\Cart\Infrastructure\Mapper;

use App\Entity\Product;
use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Application\Dto\CartDto;
use App\Api\Cart\Application\Dto\CartItemDto;
use App\Api\Cart\Domain\Contract\Dto\CartDtoFactoryInterface;
use App\Api\Cart\Domain\Contract\Repository\ProductRepositoryInterface;

final class CartDtoFactory implements CartDtoFactoryInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {}

    public function create(Cart $cart): CartDto
    {

        $cartDto = new CartDto($cart);

        $totalPrice = 0.0;

        foreach ($cart->getItems() as $cartItem) {
            /** @var Product $product  */
            if ($product = $this->productRepository->findById($cartItem->getProductId())) {
                $cartItemDto = new CartItemDto(
                    $cartItem->getProductId(),
                    $product->getName(),
                    $cartItem->getQuantity(),
                    (float) $product->getPrice()
                );

                $cartDto->addItem($cartItemDto);

                $totalPrice += (float) $product->getPrice() * $cartItem->getQuantity()->getValue();
            }
        }

        $cartDto->setTotalPrice($totalPrice);

        return $cartDto;
    }
}

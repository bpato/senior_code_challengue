<?php
namespace App\Api\Checkout\Infrastructure\Factory;

use App\Api\Checkout\Domain\Entity\Order;
use App\Api\Checkout\Domain\Entity\Product;
use App\Api\Cart\Application\Dto\CartSnapshot;
use App\Api\Checkout\Domain\ValueObject\CartId;
use App\Api\Checkout\Domain\Entity\OrderProduct;
use App\Api\Checkout\Domain\ValueObject\OrderId;
use App\Api\Checkout\Domain\ValueObject\Quantity;
use App\Api\Checkout\Domain\ValueObject\ProductId;
use App\Api\Checkout\Domain\ValueObject\OrderEmail;
use App\Api\Checkout\Domain\Contract\Dto\OrderFactoryInterface;
use App\Api\Checkout\Application\Exception\ProductNotFoundException;
use App\Api\Checkout\Domain\Contract\Repository\ProductRepositoryInterface;

class OrderFactory implements OrderFactoryInterface
{

    private Order $newOrder;

    public function __construct(
        private ProductRepositoryInterface $productRepository
    )
    {
        $this->newOrder = new Order();
    }

    public function forCustomer(OrderEmail $email): self
    {
        $this->newOrder->setEmail($email);

        return $this;
    }

    public function createFrom(CartSnapshot $cart): self
    {
        $this->newOrder->setCartReference(new CartId($cart->id));

        foreach ($cart->getItems() as $item) {

            $productId = new ProductId($item->product_id);
            $quantity = new Quantity($item->quantity);

            /** @var Product $product */
            if (! $product = $this->productRepository->findById($productId)) {
                // lanzar evento borrar item
                throw new ProductNotFoundException($productId);
            }

            $newOrderProduct = new OrderProduct();
            $newOrderProduct->setProductId($productId)
                ->setName($product->getName())
                ->setPrice($product->getPrice())
                ->setQuantity($quantity)
                ->calculateTotalPrice();

            $this->newOrder->addOrderProduct($newOrderProduct);
        }


        $this->newOrder->calculateTotalPrice();
        $this->newOrder->calculateTotalQuantity();

        return $this;
    }

    public function get(): Order
    {
        return $this->newOrder;
    }

}

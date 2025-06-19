<?php

namespace App\Api\Checkout\Infrastructure\Repository;

use Symfony\Component\Uid\Uuid;
use App\Api\Checkout\Domain\Entity\Order;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product as DoctrineProduct;
use App\Api\Checkout\Domain\ValueObject\Price;
use App\Entity\PurchaseOrder as DoctrineOrder;
use App\Api\Checkout\Domain\ValueObject\CartId;
use App\Api\Checkout\Domain\Entity\OrderProduct;
use App\Api\Checkout\Domain\ValueObject\OrderId;
use App\Api\Checkout\Domain\ValueObject\Quantity;
use App\Api\Checkout\Domain\ValueObject\ProductId;
use App\Api\Checkout\Domain\ValueObject\OrderEmail;
use App\Api\Checkout\Domain\ValueObject\ProductName;
use App\Entity\OrderProduct as DoctrineOrderProduct;
use App\Api\Checkout\Domain\ValueObject\OrderProductId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Api\Checkout\Domain\Contract\Repository\OrderRepositoryInterface;

final class DoctrineOrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineOrder::class);
    }

    public function findById(OrderId $id): ?Order
    {
        /** @var DoctrineOrder $doctrineOrder */
        $doctrineOrder = $this->createQueryBuilder('o')
            ->where('o.id = :id')
            ->setParameter('id', $id->getValue())
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();

        if (!$doctrineOrder) {
            return null;
        }

        $order = (new Order())
            ->setId(new OrderId($doctrineOrder->getId()))
            ->setCartReference(new CartId($doctrineOrder->getCartReference()))
            ->setEmail(new OrderEmail($doctrineOrder->getEmail()))
            ->setCreatedAt($doctrineOrder->getCreatedAt())
            ->setTotalPrice(new Price($doctrineOrder->getTotalPrice()))
            ->setTotalQuantity(new Quantity($doctrineOrder->getTotalItems()));


        foreach ($doctrineOrder->getOrderProducts() as $doctrineOrderProduct) {
            $orderProduct = (new OrderProduct())
                ->setId(new OrderProductId($doctrineOrderProduct->getId()))
                ->setProductId(new ProductId($doctrineOrderProduct->getProductId()))
                ->setName(new ProductName($doctrineOrderProduct->getName()))
                ->setPrice(new Price($doctrineOrderProduct->getUnitPrice()))
                ->setTotalPrice(new Price($doctrineOrderProduct->getTotalPrice()))
                ->setQuantity(new Quantity($doctrineOrderProduct->getQuantity()));

            $order->addOrderProduct($orderProduct);
        }

        return $order;
    }

    public function save(Order $order): ?OrderId
    {
        $newDoctrineOrder = new DoctrineOrder();
        $newDoctrineOrder
            ->setCartReference(new Uuid($order->getCartReference()->getValue()))
            ->setEmail($order->getEmail()->getValue())
            ->setTotalPrice($order->getTotalPrice()->getValue())
            ->setTotalItems($order->getTotalQuantity()->getValue())
            ->setCreatedAt(new \DateTimeImmutable());

        /** @var OrderProduct $orderProduct */
        foreach ($order->getOrderProducts() as $orderProduct) {

            $newDoctrineOrderProduct = new DoctrineOrderProduct();

            $newDoctrineOrderProduct->setProductId($orderProduct->getProductId()->getValue())
                ->setName($orderProduct->getName()->getValue())
                ->setUnitPrice($orderProduct->getPrice()->getValue())
                ->setTotalPrice($orderProduct->getTotalPrice()->getValue())
                ->setQuantity($orderProduct->getQuantity()->getValue());

            $newDoctrineOrder->addOrderProduct($newDoctrineOrderProduct);
        }

        $this->getEntityManager()->persist($newDoctrineOrder);
        $this->getEntityManager()->flush();

        return new OrderId($newDoctrineOrder->getId());
    }
}

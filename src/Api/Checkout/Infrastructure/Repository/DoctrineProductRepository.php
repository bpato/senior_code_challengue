<?php

namespace App\Api\Checkout\Infrastructure\Repository;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Product as DoctrineProduct;
use App\Api\Checkout\Domain\Entity\Product;
use App\Api\Checkout\Domain\ValueObject\ProductId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Api\Checkout\Domain\Contract\Repository\ProductRepositoryInterface;
use App\Api\Checkout\Domain\ValueObject\Price;
use App\Api\Checkout\Domain\ValueObject\ProductName;

final class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineProduct::class);
    }

    public function findById(ProductId $id): ?Product
    {
        $doctrineProduct = $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id->getValue())
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();

        if (!$doctrineProduct) {
            return null;
        }

        return (new Product())
            ->setId(new ProductId($doctrineProduct->getId()))
            ->setName(new ProductName($doctrineProduct->getName()))
            ->setPrice(new Price($doctrineProduct->getPrice()));

    }
}

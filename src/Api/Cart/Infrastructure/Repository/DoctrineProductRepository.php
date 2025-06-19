<?php

namespace App\Api\Cart\Infrastructure\Repository;

use App\Entity\Product as DoctrineEntity;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Api\Cart\Domain\Contract\Repository\ProductRepositoryInterface;
use App\Api\Cart\Domain\ValueObject\ProductId;

final class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineEntity::class);
    }

    public function findById(ProductId $id): ?object
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id->getValue())
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}

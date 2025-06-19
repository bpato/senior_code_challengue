<?php

namespace App\Api\Cart\Infrastructure\Repository;

use App\Api\Cart\Domain\Entity\Cart;
use App\Api\Cart\Domain\ValueObject\CartId;
use App\Api\Cart\Domain\Contract\Repository\CartRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;

final class CacheCartRepository implements CartRepositoryInterface
{

    private const CACHE_PREFIX = 'cart_';
    private const CACHE_TTL = 86400;

    public function __construct(
        private CacheItemPoolInterface $cachePool
    ) {
    }

    public function save(Cart $cart): CartId
    {
        $cacheItem = $this->cachePool->getItem(self::CACHE_PREFIX . $cart->getId()->getValue());
        $cacheItem->set($cart);
        $cacheItem->expiresAfter(self::CACHE_TTL);
        $this->cachePool->save($cacheItem);

        return $cart->getId();
    }

    public function findById(CartId $id): ?Cart
    {
        $cacheItem = $this->cachePool->getItem(self::CACHE_PREFIX . $id->getValue());
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        return null;
    }

    public function delete(Cart $cart): void
    {
        $cacheItem = $this->cachePool->getItem(self::CACHE_PREFIX . $cart->getId()->getValue());
        if ($cacheItem->isHit()) {
            $this->cachePool->deleteItem(self::CACHE_PREFIX . $cart->getId()->getValue());
        }
    }

    public function update(Cart $cart): ?Cart
    {
        $this->save($cart);
        return $this->findById($cart->getId());
    }
}

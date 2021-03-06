<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PromotionsBundle\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use DateTime;

/**
 * Promotion repository.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class PromotionRepository extends EntityRepository implements PromotionRepositoryInterface
{
    public function findActive()
    {
        $qb = $this->getCollectionQueryBuilder();

        return $qb
            ->where($qb->expr()->andx(
                $qb->expr()->lt($this->getAlias().'.startsAt', ':now'),
                $qb->expr()->gt($this->getAlias().'.endsAt', ':now')
            ))
            ->setParameter('now', new DateTime())
            ->getQuery()
            ->getResult()
        ;
    }
}

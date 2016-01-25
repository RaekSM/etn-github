<?php

namespace App\Model;

use Nette,
    App\Search;

/**
 * Class of TimeDelete
 */
class TimeDelete extends Nette\Object
{

    /**
     * @var \Kdyby\Doctrine\EntityManager
     */
    public $em;

    // inject doctrine entity mamager to object
    public function __construct(\Kdyby\Doctrine\EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /*
     * Delete data by time
     *
     * @param string $value hours from form
     *
     * @return int
     */
    public function delete($value)
    {
        // formating hours on date
        $date = new \DateTime(strtotime(time()));
        $date = $date->modify('-' . $value . 'hours')->format('Y-m-d H:i:s');

        // deleting rows by doctrine with cascade delete entity settings in db schema
        $qb = $this->em->createQueryBuilder();
        $q = $qb->delete(Search::getClassName(), 's')->where(
            $qb->expr()->lt('s.date', '?1')
        )
            ->setParameter(1, $date)
            ->getQuery();
        return $numberDeleted = $q->getResult();
    }
}
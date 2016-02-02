<?php
namespace App;

use Kdyby\Doctrine\QueryBuilder;
use Kdyby\Persistence\Queryable;
use Nette;


class SearchQuery extends \Kdyby\Doctrine\QueryObject
{

    private $select = [];
    private $filter = [];

    public function searchById($id = NULL)
    {
        $this->filter[] = function (QueryBuilder $qb) use ($id) {
            $qb->where('Search.id = :id', $id);
        };

        return $this;
    }

    /**
     * @param Queryable $repository
     * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder|\Kdyby\Doctrine\NativeQueryWrapper
     */
    protected function doCreateQuery(Queryable $repository)
    {
        $qb = $this->createBasicDql($repository);

        return $qb;
    }

    /**
     * @param Queryable|Kdyby\Doctrine\EntityDao $repository
     * @return NativeQueryBuilder
     */
    private function createBasicDql(Queryable $repository)
    {
        $qb = $repository->createQueryBuilder('Search');

        foreach ($this->filter as $modifier) {
            $modifier($qb);
        }

        return $qb;
    }

}
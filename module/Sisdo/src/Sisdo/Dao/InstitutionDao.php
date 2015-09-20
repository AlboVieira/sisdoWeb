<?php

/**
 * Created by PhpStorm.
 * User: albov
 * Date: 19/08/2015
 * Time: 23:35
 */

namespace Sisdo\Dao;

use Application\Custom\DaoAbstract;

class InstitutionDao extends DaoAbstract
{
    protected $entityName = 'Sisdo\\Entity\\Institution';

    public function findAll(){

        $this->getCompleteQueryBuilder()->getQuery()->getArrayResult();
    }

    public function findNameInstitutionByTerm($term){
        $qb = $this->createQueryBuilder()
            ->select($this->alias . DaoAbstract::TABLE_COLUMN_SEPARATOR . 'id',
                $this->alias . DaoAbstract::TABLE_COLUMN_SEPARATOR . 'fancyName')
            ->from($this->entityName, $this->alias)
            ->where($this->alias . DaoAbstract::TABLE_COLUMN_SEPARATOR . "fancyName LIKE  '%{$term}%'")
            ->orderBy($this->alias . DaoAbstract::TABLE_COLUMN_SEPARATOR . 'fancyName', 'asc');

        return $qb->getQuery()->getArrayResult();

    }

    public function findInstitutionsByUF($uf)
    {

        $qb = $this->getQueryBuilder();
        $qb->leftJoin($this->getAlias() . '.userId', 'u')
            ->leftJoin('u.adress', 'a')
            ->where('a.uf = :uf')
            ->setParameter('uf', $uf);

        return $qb->getQuery()->getResult();
    }
}
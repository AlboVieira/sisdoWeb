<?php

/**
 * Created by PhpStorm.
 * User: albov
 * Date: 19/08/2015
 * Time: 23:35
 */

namespace GerenciaEstoque\Dao;

use Application\Custom\DaoAbstract;

class ProdutoDao extends DaoAbstract
{
    protected $entityName = 'GerenciaEstoque\\Entity\\Produto';

    public function findAll()
    {
        $qb = $this->getCompleteQueryBuilder();
        return $qb->getQuery()->getArrayResult();
    }

}
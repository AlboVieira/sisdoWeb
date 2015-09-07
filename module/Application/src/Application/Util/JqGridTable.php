<?php

/**
 * Created by PhpStorm.
 * User: albov
 * Date: 19/08/2015
 * Time: 23:52
 */
namespace Application\Util;

use Application\Constants\JqGridConst;
use Doctrine\ORM\QueryBuilder;

class JqGridTable
{
    private $title;
    private $colunas = array();
    private $url;
    private $widthTable = 900;

    private $queryBuilder;
    private $alias;
    private $collapse = false;

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAlias($alias){
        $this->alias = $alias;
    }

    public function setWidth($width){
        $this->widthTable = $width;
    }

    public function setUrl($url){
        $this->url = $url;
    }

    public function addColunas($coluna){
        array_push($this->colunas, $coluna);
    }

    public function getColunas(){

        return json_encode($this->colunas);
    }

    public function setQuery(QueryBuilder $qb){
        $this->queryBuilder = $qb;
        return $this;
    }

    public function getTodosRegistros()
    {
        $qb = clone $this->queryBuilder;

        $results = $qb
            ->getQuery()
            ->getResult();

        //$this->lastQuery = $qb->getQuery()->getSQL();

        return $results;
    }

    public function getDatatableArray()
    {
        $qtde = $this->getCount();

        return array(
            JqGridConst::PARAM_REGISTROS => $this->getTodosRegistros(),
            JqGridConst::PARAM_QTD_TOTAL => $qtde,
            JqGridConst::PARAM_REGISTRO_ENCONTRADOS => $qtde,
        );
    }

    public function getCount()
    {
        $qb = clone $this->queryBuilder;

        $results = $qb
            ->select('COUNT('.$this->alias.')')
            ->getQuery()
            ->getSingleScalarResult();

        //$this->lastQuery = $qb->getQuery()->getSQL();

        return $results;
    }


    public function getParametrosFromPost()
    {
        /*
        $parametros = array();

        if (isset($_GET[])) {
            $parametros[self::PARAM_COLUNAS] = $_GET[self::PARAM_COLUNAS];
        }
        */
    }

    /**
     * @return mixed
     */
    public function getCollapse()
    {
        return $this->collapse;
    }

    /**
     * @param mixed $collapse
     */
    public function setCollapse($collapse)
    {
        $this->collapse = $collapse;
    }



    public function renderJs(){

        $colunas = $this->getColunas();
        $collapse = $this->collapse ? 'true' : 'false';

        return <<<EOF

        <div style="margin-left:20px">
            <table id="jqGrid"></table>
            <div id="jqGridPager"></div>
        </div>

        <script>
        $(document).ready(function () {
            //$.jgrid.no_legacy_api = true;
            //$.jgrid.useJSON = true;
            $.jgrid.defaults.width = $this->widthTable;
            $("#jqGrid").jqGrid({
                url: '$this->url',
                mtype: "GET",
                styleUI : 'Bootstrap',
                datatype: "json",
                colModel: $colunas,
                viewrecords: true,
                height: 250,
                rowNum: 10,
                pager: "#jqGridPager",
                caption: "<h4><b>$this->title</b></h4>",
                jsonReader: {repeatitems: false},
                autoWidth:true,
                hiddengrid: $collapse
                //shrink:true
            });
        });
        </script>
EOF;
    }

}
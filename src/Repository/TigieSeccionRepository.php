<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * TigieSeccionRepository
 */
class TigieSeccionRepository extends EntityRepository
{
    public function _treeView(){
        $em = $this->getEntityManager();
        $qb = new QueryBuilder($em);
        $fields='partial ts.{id,numero}, partial cp.{id,descripcion}, partial pt.{id_partida,numero,inicioVigencia,finVigencia,descripcion}, partial spt.{id_supartida,numero,inicioVigencia,finVigencia}, partial frs.{numero,inicioVigencia,finVigencia,descripcion}';
        return $qb->select($fields)
            ->from('App:TigieSeccion','ts')
            ->leftJoin('ts.capitulos','cp')
            ->leftJoin('cp.cpartidas','pt')
            ->leftJoin('pt.subpartidas','spt')
            ->leftJoin('spt.fracciones','frs')
            ->getQuery()->getArrayResult();
    }

    public function fracciones($id_partida){
        $em = $this->getEntityManager();
        $qb = new QueryBuilder($em);
        $fields='partial spt.{id_supartida,numero,descripcion,inicioVigencia,finVigencia,nivel1,nivel2}, partial frs.{numero,inicioVigencia,finVigencia,descripcion}';
        return $qb->select($fields)
            ->from('App:TigieSubpartida','spt')
            ->leftJoin('spt.fracciones','frs')
            ->where('spt.partida=:id')
            ->setParameter('id',$id_partida)//
            ->orderBy('spt.inicioVigencia','DESC')
            ->getQuery()->getArrayResult();
    }

    public function treeView(){
        $em = $this->getEntityManager();
        $qb = new QueryBuilder($em);
        $fields='partial ts.{id,numero,descripcion}, partial cp.{id,descripcion,capitulo}, partial pt.{id_partida,numero,inicioVigencia,finVigencia,descripcion}';
        return $qb->select($fields)
            ->from('App:TigieSeccion','ts')
            ->leftJoin('ts.capitulos','cp')
            ->leftJoin('cp.cpartidas','pt')
            ->getQuery()->getArrayResult();
    }
}

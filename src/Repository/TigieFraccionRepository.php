<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * TigieFraccionRepository
 */
class TigieFraccionRepository extends EntityRepository
{
    public function findByNumeroLikeQuery($q, $exacto = false)
    {
        if (!$q)
            return [];

        $qb = $this->createQueryBuilder("f")
            ->where("f.numero LIKE :q");

        if ($exacto)
            $qb->setParameter("q", $q);
        else
            $qb->setParameter("q", "%".$q."%");

        return  $qb->getQuery()->getResult();
    }
    public function detalle($id){
        $em = $this->getEntityManager();
        $qb = new QueryBuilder($em);
        $fields='partial ts.{id,numero,descripcion}, 
        partial cp.{id,descripcion,capitulo}, 
        partial pt.{id_partida,numero,inicioVigencia,finVigencia,descripcion}, 
        partial spt.{id_supartida,numero,inicioVigencia,finVigencia,descripcion,nivel1,nivel2}, 
        partial frs.{numero,inicioVigencia,finVigencia,descripcion,tipo_aran,adv_imp,exenta}';
        return $qb->select($fields)
            ->from('App:TigieSeccion','ts')
            ->leftJoin('ts.capitulos','cp')
            ->leftJoin('cp.cpartidas','pt')
            ->leftJoin('pt.subpartidas','spt')
            ->leftJoin('spt.fracciones','frs')
            ->where('frs.numero=:id')
            ->setParameter('id',$id)
            ->addOrderBy('spt.inicioVigencia','DESC')
            ->addOrderBy('frs.inicioVigencia','DESC')
            ->getQuery()->getArrayResult();
    }

    public function fraccionNormas($id){
        $em = $this->getEntityManager();
        $qb = new QueryBuilder($em);
        $fields='partial fr.{numero,inicioVigencia,finVigencia,descripcion,tipo_aran,adv_imp,exenta},
        partial nms.{fraccion,idNom,iniVig,finVig,cveUniExc,cveParcialidad,descParcialidad},
        partial nm.{idNom,iniVig,finVig,norma,cpdPed,artNom},
        partial scr.{cveSecretaria,nombreSecretaria,descPermiso}';
        return $qb->select($fields)
            ->from('App:TigieFraccion','fr')
            ->leftJoin('fr.noms','nms')
            ->leftJoin('nms.idNom','nm')
            ->leftJoin('nm.cveSecretaria','scr')
            ->where('fr.numero=:id')
            ->andWhere('CURRENT_DATE() BETWEEN nm.iniVig AND nm.finVig')
            ->andWhere('CURRENT_DATE() BETWEEN nms.iniVig AND nms.finVig')
            ->orderBy('fr.inicioVigencia','DESC')
            ->setParameter('id',$id)
            ->getQuery()->getArrayResult();
    }


    public function fraccionPermisos($id){
        $em = $this->getEntityManager();
        $qb = new QueryBuilder($em);
        $fields='partial fr.{numero,inicioVigencia,finVigencia,descripcion,tipo_aran,adv_imp,exenta},
        partial prms.{fraccion,idPermiso,iniVig,finVig,parcialidad,descParcU},
        partial prm.{idPermiso,iniVig,finVig,descPermiso,cvePermiso,articuloNo},
        partial prmsec.{cveSecretaria,nombreSecretaria}';
        return $qb->select($fields)
            ->from('App:TigieFraccion','fr')
            ->leftJoin('fr.permisos','prms')
            ->leftJoin('prms.idPermiso','prm')
            ->leftJoin('prm.cveSecretaria','prmsec')
            ->where('fr.numero=:id')
            ->andWhere('CURRENT_DATE() BETWEEN prms.iniVig AND prms.finVig')
            ->andWhere('CURRENT_DATE() BETWEEN prm.iniVig AND prm.finVig')
            ->orderBy('fr.inicioVigencia','DESC')
            ->setParameter('id',$id)
            ->getQuery()->getArrayResult();
    }
}

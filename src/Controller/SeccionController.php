<?php
/**
 * User: taowl
 * Date: 1/9/18
 * Time: 8:44 AM
 */

namespace App\Controller;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Doctrine\DBAL\DBALException;
use Exception;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

use App\Entity\CargaTarifa;

/**
 * Class SeccionController
 *
 * @Route("/api/v1/secciones")
 */
class SeccionController extends FOSRestController
{//
    /**
     * @Rest\Get(".{_format}", name="secciones_listar", defaults={"_format":"json"})
     
     * @SWG\Get(
     *      summary="Listar Secciones",
     *     produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Devuelve las secciones"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al devolver las secciones."
     * )
     *
     * @SWG\Tag(name="Secciones")
     * @param Request $request
     * @return Response
     */
    public function listarSeccionesAction(Request $request) {
        $serializer = $this->container->get('jms_serializer');
        $entityManager = $this->getDoctrine()->getManager();
        $secciones = $entityManager->getRepository("App:TigieSeccion")->treeView();
        return new Response($serializer->serialize($secciones, "json"), 200);        
    }
}
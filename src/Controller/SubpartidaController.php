<?php
/**
 * User: taowl
 * Date: 1/9/18
 * Time: 8:44 AM
 */

namespace App\Controller;

use Doctrine\DBAL\DBALException;
use Exception;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class SubpartidaController
 *
 * @Route("/api/v1/subpartida")
 */
class SubpartidaController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="subpartida_listar", defaults={"_format":"json"})
     *
     * @SWG\Parameter(
     *     name="q",
     *     in="path",
     *     type="string",
     *     description="clave para la búsqueda.  {CodigoCapitulo}{CodigoPartida}{CodigoSubpartida}",
     *     schema={}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas las sub-partidas disponibles basados en el query."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener las sub-partidas."
     * )
     *
     * @SWG\Tag(name="Sub partida")
     * @param Request $request
     * @return Response
     */
    public function getSubpartidasAction(Request $request) {

        ini_set('memory_limit', '-1');
        $serializer  = $this->get('jms_serializer');
        $em          = $this->getDoctrine()->getManager();
        $subpartidas    = [];
        $message     = "";

        try {
            $code = 200;
            $error = false;

            $q = $request->get("q");

            if ($q){
                $subpartidas = $em->getRepository("App:TigieSubpartida")->findByCodigoQuery($q);
            }

            if (is_null($subpartidas))
                $subpartidas = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener las subpartidas - Error: DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos las subpartidas - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $subpartidas : $message,
        ];

        return new Response($serializer->serialize(
            $code == 200 ? $subpartidas : $response, "json", null,
            array(
                "groups" => array("subpartidas")
            )
        ), $code);
    }

}
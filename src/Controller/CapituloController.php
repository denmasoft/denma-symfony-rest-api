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
 * Class CapituloController
 *
 * @Route("/api/v1/capitulo")
 */
class CapituloController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="capitulo_listar", defaults={"_format":"json"})
     *
     * @SWG\Parameter(
     *     name="q",
     *     in="path",
     *     type="string",
     *     description="clave para la búsqueda. {CodigoCapitulo}",
     *     schema={}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas los capitulos disponibles basados en el query."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener los capitulos."
     * )
     *
     * @SWG\Tag(name="Capitulo")
     * @param Request $request
     * @return Response
     */
    public function getCapitulosAction(Request $request) {

        ini_set('memory_limit', '-1');
        $serializer  = $this->get('jms_serializer');
        $em          = $this->getDoctrine()->getManager();
        $capitulos   = [];
        $message     = "";

        try {
            $code = 200;
            $error = false;

            $q = $request->get("q");

            if ($q)
                $capitulos = $em->getRepository("App:Capitulo")->findBy(array(
                    "codigo" => $q
                ));

            if (is_null($capitulos))
                $capitulos = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los capitulos - Error: DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los capitulos - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $capitulos : $message,
        ];

        return new Response($serializer->serialize($code == 200 ? $capitulos : $response, "json"), $code);
    }

}
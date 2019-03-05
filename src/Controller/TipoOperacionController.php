<?php
/**
 * User: taowl
 * Date: 3/9/18
 * Time: 9:41 AM
 */
namespace App\Controller;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TipoOperacionController
 *
 * @Route("/api/v1/tipo_operacion")
 */
class TipoOperacionController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="tipo_operacion_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todos los tipos de operaciones disponibles para el registro de fracciones arancelarias."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de tipo de operaciones."
     * )
     *
     * @SWG\Tag(name="Fracción")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getTipoFraccionesAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $tipoOperaciones  = [];
        $message     = "";

        try {
            $code = 200;
            $error = false;

            $tipoOperaciones = $em->getRepository("App:TipoOperacion")->findAll();

            if (is_null($tipoOperaciones))
                $tipoOperaciones = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener los tipo de operaciones: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todas las operaciones: {$ex->getMessage()}";
        }

        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];

        return new Response($serializer->serialize($code == 200 ? $tipoOperaciones : $response, "json"), $code);
    }
}
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
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * Class FraccionController
 *
 * @Route("/api/v1/unidad")
 */
class UnidadesController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="unidad_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene todas las unidades disponibles para el registro de fracciones arancelarias."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener la lista de unidades de medida."
     * )
     *
     * @SWG\Tag(name="Fracción")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function getUnidadesAction(SerializerInterface $serializer, EntityManagerInterface $em) {

        $unidades  = [];
        $message     = "";

        try {
            $code = 200;
            $error = false;

            $unidades = $em->getRepository("App:Unidad")->findAll();

            if (is_null($unidades))
                $unidades = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener las unidades de medida: Error en DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todas las unidades: {$ex->getMessage()}";
        }

        $response = [
            'code'  => $code,
            'error' => $error,
            'data'  => $message,
        ];

        return new Response($serializer->serialize($code == 200 ? $unidades : $response, "json"), $code);
    }
}
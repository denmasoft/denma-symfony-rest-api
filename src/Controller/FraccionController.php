<?php
/**
 * User: taowl
 * Date: 1/9/18
 * Time: 8:44 AM
 */

namespace App\Controller;

use App\Entity\TigieFraccion;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class FraccionController
 *
 * @Route("/api/v1/fraccion")
 */
class FraccionController extends FOSRestController
{

    /**
     * @Rest\Get(".{_format}", name="fraccion_listar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Obtiene las fracciones basados en el parametro query."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al obtener todos las fracciones."
     * )
     *
     * @SWG\Tag(name="Fracción")
     * @param Request $request
     * @return Response
     */
    public function getFraccionesAction(Request $request) {

        ini_set('memory_limit', '-1');
        $serializer  = $this->get('jms_serializer');
        $em          = $this->getDoctrine()->getManager();
        $fracciones  = [];
        $message     = "";

        try {
            $code = 200;
            $error = false;

            $q = $request->get("q");
            $fracciones = $em->getRepository("App:TigieFraccion")->findByNumeroLikeQuery($q, $request->get("exacto"));

            if (is_null($fracciones))
                $fracciones = [];

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error obtenido al intentar obtener las fracciones - Error: DB.";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al obtener todos los documentos - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $fracciones : $message,
        ];

        return new Response($serializer->serialize($code == 200 ? $fracciones : $response, "json"), $code);
    }

    /**
     * @Rest\Post(".{_format}", name="fraccion_nueva", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Crea una nueva fracción para el usuario logeado."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al crear una nueva fraccion."
     * )
     *
     * @SWG\Parameter(
     *     name="numero",
     *     in="body",
     *     type="string",
     *     description="Numero de la fracción  arancelaria.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripción de la fracción  arancelaria.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="exenta",
     *     in="body",
     *     type="boolean",
     *     description="Indica si la fracción  arancelaria está exenta o no.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="prohibida",
     *     in="body",
     *     type="boolean",
     *     description="Indica si la fracción  arancelaria es prohibida.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="inicio_vigencia",
     *     in="body",
     *     type="datetime",
     *     description="Fecha a partir del cual la fracción arancelaria está vigente.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fin_vigencia",
     *     in="body",
     *     type="datetime",
     *     description="Fecha de vencimiento para la fracción arancelaria.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="impuesto_advalorem",
     *     in="body",
     *     type="string",
     *     description="Valor del impuesto Advalorem",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="impuesto_especifico",
     *     in="body",
     *     type="string",
     *     description="Valor del impuesto específico.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Fracción")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function postNuevaOperacion (SerializerInterface $serializer, EntityManagerInterface $em, Request $request) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;
            $fraccion = new TigieFraccion();
            $fraccion->setNumero($request->get('numero'));
            $fraccion->setDescripcion($request->get('descripcion'));
            $fraccion->setFinVigencia(new \DateTime($request->get('fin_vigencia')));
            $fraccion->setInicioVigencia(new \DateTime($request->get('inicio_vigencia')));
            $fraccion->setImpuestoAdValorem($request->get('impuesto_ad_valorem'));
            $fraccion->setImpuestoEspecifico($request->get('impuesto_especifico'));
            $fraccion->setExenta($request->get('exenta'));
            $fraccion->setProhibida($request->get('prohibida'));
            $fraccion->setUsuario($this->getUser());
            $unidad = $em->getReference('App:Unidad', $request->get('unidad'));
            $operacion = $em->getReference('App:TipoOperacion', $request->get('tipo_operacion'));
            $fraccion->setUnidad($unidad);
            $fraccion->setTipoOperacion($operacion);
            $em->persist($fraccion);
            $em->flush();
            $data = $fraccion;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una fraccion: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una nueva fraccion: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }

    /**
     * @Rest\Put("/{id}.{_format}", name="fraccion_editar", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Editar una fracción para el usuario logeado."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al editar una fraccion."
     * )
     *
     * @SWG\Parameter(
     *     name="numero",
     *     in="body",
     *     type="string",
     *     description="Numero de la fracción  arancelaria.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="descripcion",
     *     in="body",
     *     type="string",
     *     description="Descripción de la fracción  arancelaria.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="exenta",
     *     in="body",
     *     type="boolean",
     *     description="Indica si la fracción  arancelaria está exenta o no.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="prohibida",
     *     in="body",
     *     type="boolean",
     *     description="Indica si la fracción  arancelaria es prohibida.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="inicio_vigencia",
     *     in="body",
     *     type="datetime",
     *     description="Fecha a partir del cual la fracción arancelaria está vigente.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="fin_vigencia",
     *     in="body",
     *     type="datetime",
     *     description="Fecha de vencimiento para la fracción arancelaria.",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="impuesto_advalorem",
     *     in="body",
     *     type="string",
     *     description="Valor del impuesto Advalorem",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="impuesto_especifico",
     *     in="body",
     *     type="string",
     *     description="Valor del impuesto específico.",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Fracción")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function putNuevaOperacion (LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {

        $message = "";
        $data = "";

        try {
            $code = 200;
            $error = false;

            $fraccion = $em->getRepository('App:TigieFraccion')->find($id);

            if (!$fraccion)
                throw new Exception("Fracción no conseguida.");

//            if ($fraccion->getUsuario()->getId() !== $this->getUser()->getId())
//                throw new Exception("Éste usuario no puede editar esta fracción.");

            if ($request->get('fin_vigencia'))
                $fraccion->setFinVigencia(new \DateTime($request->get('fin_vigencia')));

            if ($request->get('inicio_vigencia'))
                $fraccion->setInicioVigencia(new \DateTime($request->get('inicio_vigencia')));

            if ($request->get('exenta'))
                $fraccion->setExenta($request->get('exenta'));

            if ($request->get('prohibida'))
                $fraccion->setProhibida($request->get('prohibida'));

            if ($request->get('descripcion'))
                $fraccion->setDescripcion($request->get('descripcion'));

            if ($request->get('numero'))
                $fraccion->setNumero($request->get('numero'));

            if ($request->get('impuesto_ad_valorem'))
                $fraccion->setImpuestoAdValorem($request->get('impuesto_ad_valorem'));

            if ($request->get('impuesto_especifico'))
                $fraccion->setImpuestoEspecifico($request->get('impuesto_especifico'));

            if ($request->get('unidad')) {

                $unidad = $em->getReference('App:Unidad', $request->get('unidad'));
                $fraccion->setUnidad($unidad);
            }

            if ($request->get('tipo_operacion')) {

                $operacion = $em->getReference('App:TipoOperacion', $request->get('tipo_operacion'));
                $fraccion->setTipoOperacion($operacion);
            }

            $em->persist($fraccion);
            $em->flush();

            $data = $fraccion;

        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "Error al guardar una fraccion: {$ex->getMessage()}";
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Error al crear una nueva fraccion: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $data:$message
        ];

        return new Response($serializer->serialize($code == 200?$data:$response, "json"), $code);
    }
    /**
     * @Rest\Get("/{id}.{_format}", name="detalle_fraccion", defaults={"_format":"json"})
     
     * @SWG\Get(
     *      summary="Detalle Fraccion",
     *     produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Devuelve detalles de la fraccion"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al devolver la fraccion."
     * )
     *
     * @SWG\Tag(name="Fracción")
     * @param Request $request
     * @return Response
     */
    public function detalleFraccionAction(LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {
        $fraccion = $em->getRepository("App:TigieFraccion")->detalle($id);
        return new Response($serializer->serialize($fraccion, "json"), 200);        
    }
            /**
     * @Rest\Get("/arbol/{id}.{_format}", name="fracciones_arbol", defaults={"_format":"json"})
     
     * @SWG\Get(
     *      summary="Arbol Fracciones",
     *     produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Devuelve el arbol de las fracciones por partida"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al devolver las fracciones."
     * )
     *
     * @SWG\Tag(name="Fracción")
     * @param Request $request
     * @return Response
     */
    public function arbolFraccionesAction(LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {
        $fracciones = $em->getRepository("App:TigieSeccion")->fracciones($id);
        return new Response($serializer->serialize($fracciones, "json"), 200);        
    }

    /**
     * @Rest\Get("/normas/{id}.{_format}", name="normas_fracciones", defaults={"_format":"json"})

     * @SWG\Get(
     *      summary="Normas Fracciones",
     *     produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Devuelve las normas de las fraccion"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al devolver las normas de la fraccion."
     * )
     *
     * @SWG\Tag(name="Fracción")
     * @param Request $request
     * @return Response
     */
    public function normasFraccionesAction(LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {
        $fracciones = $em->getRepository("App:TigieFraccion")->fraccionNormas($id);
        return new Response($serializer->serialize($fracciones, "json"), 200);
    }


    /**
     * @Rest\Get("/permisos/{id}.{_format}", name="permisos_fracciones", defaults={"_format":"json"})

     * @SWG\Get(
     *      summary="Permisos Fracciones",
     *     produces={"application/json"}
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Devuelve los permisos de la fraccion"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al devolver los permisos."
     * )
     *
     * @SWG\Tag(name="Fracción")
     * @param Request $request
     * @return Response
     */
    public function permisosFraccionesAction(LoggerInterface $logger, SerializerInterface $serializer, EntityManagerInterface $em, Request $request, $id) {
        $fracciones = $em->getRepository("App:TigieFraccion")->fraccionPermisos($id);
        return new Response($serializer->serialize($fracciones, "json"), 200);
    }
}
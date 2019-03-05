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
 * Class ImportarExcelController
 *
 * @Route("/api/v1/importacion")
 */
class ImportarExcelController extends FOSRestController
{
    /**
     * @Rest\Post("/", name="importar_excel")
     
     * @SWG\Post(
     *      summary="Importar Excel",
     *     consumes={"multipart/form-data"}
     * ) 
     * @SWG\Parameter(
     *     name="file",
     *     in="formData",
     *     type="file",
     *     description="Archivo excel",
     *
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Importa Excel"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al importar excel."
     * )
     *
     * @SWG\Tag(name="Importacion")
     * @param Request $request
     * @return Response
     */
    public function importarAction(Request $request) {
        $serializer = $this->container->get('serializer');
        $entityManager = $this->getDoctrine()->getManager();
        $file = $request->files->get ( 'file' );
        $fileName = md5 ( uniqid () ) . '.' . $file->guessExtension ();
        $original_name = $file->getClientOriginalName ();
        $dir = $this->container->getParameter('kernel.root_dir') . '/../public/';
        $file->move ( $dir, $fileName );
        $reader = new Xlsx();
        $spreadsheet = $reader->load($dir.$fileName);
        $loadedSheetNames = $spreadsheet->getSheetNames();
        $writer = new Csv($spreadsheet);
        foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
            $writer->setSheetIndex($sheetIndex);
            $writer->save($dir.$loadedSheetName.'.csv');
            $tarifas = $serializer->decode(file_get_contents($dir.$loadedSheetName.'.csv'), 'csv');
            foreach($tarifas as $tarifa){
                try{
                    $cargaTarifa = new CargaTarifa();
                    $cargaTarifa->setCodigo($tarifa['CÓDIGO']);
                    $cargaTarifa->setDescripcion($tarifa['DESCRIPCIÓN']);
                    $cargaTarifa->setUnidad($tarifa['Unidad']);
                    $cargaTarifa->setImp($tarifa['IMP'][""]);
                    $cargaTarifa->setExp($tarifa['EXP'][""]);
                    $cargaTarifa->setFraccion($tarifa['fraccion (Num)']);
                    $cargaTarifa->setSubpartida($tarifa['Subpartida']);
                    $cargaTarifa->setIdLargo($tarifa['id_largo']);
                    $cargaTarifa->setInicioVigencia(new \DateTime($tarifa['INI_VIG']));
                    $cargaTarifa->setFinVigencia(new \DateTime($tarifa['FIN_VIG']));
                    $cargaTarifa->setDof(new \DateTime($tarifa['DOF']));
                    $entityManager->persist($cargaTarifa);
                    $entityManager->flush();  
                }
                catch (UniqueConstraintViolationException $e) {
                    $this->getDoctrine()->resetManager();
                }
            }
        }
        return new Response('ok', 200);
    }
}
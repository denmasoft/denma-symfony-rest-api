<?php
/**
 * Created by PhpStorm.
 * User: alexperaza
 * Date: 1/9/18
 * Time: 12:31 PM
 */

namespace App\Command;


use App\Entity\Capitulo;
use App\Entity\Fraccion;
use App\Entity\Partida;
use App\Entity\Subpartida;
use App\Entity\TipoOperacion;
use App\Entity\Unidad;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Negotiation\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ImportarCapitulo extends Command
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('seed:importar')

            // the short description shown while running "php bin/console list"
            ->setDescription('Importa capitulos/partidas/subpartidas')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Este comando agrega los datos de capitulos/partidas/subpartidas desde archivos de importación de excel.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $basePath = getcwd()."/src/Command/csvs/";
        $capitulosPath   = "capitulos.csv";
        $partidasPath    = "partidas.csv";
        $subpartidasPath = "subpartidas.csv";
        $fraccionesPath  = "fracciones.csv";

        $output->writeln("Importando capitulos.");
        /**
         * Importa los capitulos
         */
        $capituloArr = $this->parseCSV($basePath.$capitulosPath, 1);
        $mapCapIds   = [];           // Mantiene la información del id del capitulo en el csv y el id asignado en database.
        if ($capituloArr) {

            foreach ($capituloArr as $c) {

                $capitulo = new Capitulo();
                $capitulo->setNombre( $c[1]);
                $capitulo->setEstado($c[4] === "SI");
                $capitulo->setCodigo($c[0]);
                $capitulo->setInicioVigencia($this->parseDate($c[2]));
                $capitulo->setFinVigencia($this->parseDate($c[3]));
                $this->em->persist($capitulo);
                $this->em->flush();
                $mapCapIds[] = array(
                    "csvId"    => $c[0],
                    "capitulo" => $capitulo->getId()
                );
            }

        } else {

            $output->writeln("The file not exist or empty.");
        }
        unset($capituloArr);

        /**
         * Importa las partidas
         */
        $output->writeln("Importando Partidas.");
        $partidasArr = $this->parseCSV($basePath.$partidasPath, 1);
        $mapParIds   = [];
        if ($partidasArr) {

            foreach ($partidasArr as $p) {

                $partida = new Partida();
                $partida->setEstado($p[6] === "SI");
                $partida->setNombre($p[3]);
                $partida->setCodigo($p[2]);
                $partida->setInicioVigencia($this->parseDate($p[4]));
                $partida->setFinVigencia($this->parseDate($p[5]));

                foreach ($mapCapIds as $m) {

                    if ($m["csvId"] !== $p[0])
                        continue;
                    $capitulo = $this->em->getReference("App\Entity\Capitulo", $m["capitulo"]);
                    $partida->setCapitulo($capitulo);
                    break;
                }

                $this->em->persist($partida);
                $this->em->flush();
                $mapParIds[] = array(
                    "csvId"    => $p[2],
                    "partida"  => $partida->getId(),
                    "capitulo" => $p[0]
                );
            }
        }
        unset($partidasArr);
        unset($mapCapIds);

        /**
         * Importa las subpartidas
         */
        $output->writeln("Importando Subpartidas.");
        $partidasArr = $this->parseCSV($basePath.$subpartidasPath, 1);
        $mapSubIds   = [];
        if ($partidasArr) {

            foreach ($partidasArr as $s) {

                $subpartida = new Subpartida();
                $subpartida->setEstado($s[6] === "SI");
                $subpartida->setNombre($s[3]);
                $subpartida->setCodigo($s[2]);
                $subpartida->setInicioVigencia($this->parseDate($s[4]));
                $subpartida->setFinVigencia($this->parseDate($s[5]));

                foreach ($mapParIds as $m) {

                    if ($m["csvId"] !== $s[1] || $m["capitulo"] !== $s[0])
                        continue;
                    $partida  = $this->em->getReference("App\Entity\Partida" , $m["partida"]);
                    $subpartida->setPartida($partida);
                    break;
                }

                $this->em->persist($subpartida);
                $this->em->flush();
                $mapSubIds[] = array(
                    "csvId"      => $s[2],
                    "subpartida" => $subpartida->getId(),
                    "partida"    => $s[1],
                    "capitulo"   => $s[0]
                );
            }
        }
        unset($partidasArr);
        unset($mapParIds);

        /*
         * Importa las fracciones
         */
        $output->writeln("Importando Fracciones/Tipo de operacion/Unidades.");
        $fraccionesArr = $this->parseCSV($basePath.$fraccionesPath, 1);
        $unidades      = [];
        $operaciones   = [];
        if ($fraccionesArr) {

            foreach ($fraccionesArr as $f) {

                $fraccion = new Fraccion();
                $fraccion->setNumero($f[3]);
                $fraccion->setInicioVigencia($this->parseDate($f[7]));
                $fraccion->setFinVigencia($this->parseDate($f[8]));
                $fraccion->setActivo($f[9] === "SI");
                $fraccion->setDescripcion($f[4]);

                /** Registra la operación si no lo está */
                if (array_key_exists($f[5], $operaciones)) {
                    $operacion = $this->em->getReference("App\Entity\TipoOperacion" ,$operaciones[$f[5]]);
                } else {
                    $operacion = new TipoOperacion();
                    $operacion->setNombre($f[5]);
                    $this->em->persist($operacion);
                    $this->em->flush();
                    $operaciones[$f[5]] = $operacion->getId();
                }
                $fraccion->setTipoOperacion($operacion);

                /** Registra la unidad si no se encuentra */
                if (array_key_exists($f[6], $unidades)) {
                    $unidad = $this->em->getReference("App\Entity\Unidad" ,$unidades[$f[6]]);
                } else {
                    $unidad = new Unidad();
                    $unidad->setNombre($f[6]);
                    $this->em->persist($unidad);
                    $this->em->flush();
                    $unidades[$f[6]] = $unidad->getId();
                }
                $fraccion->setUnidad($unidad);

                foreach ($mapSubIds as $m) {

                    if ($m["csvId"] !== $f[2] || $m["capitulo"] !== $f[0] || $m["partida"] !== $f[1])
                        continue;
                    $subpartida  = $this->em->getReference("App\Entity\Subpartida" , $m["subpartida"]);
                    $fraccion->setSubpartida($subpartida);
                    break;
                }

                $this->em->persist($fraccion);
            }
            unset($mapSubIds);
            unset($fraccionesArr);

            $this->em->flush();
        }

        $output->writeln("Ready!.");
    }

    /**
     * Convierte un archivo csv en un arreglo
     * @param $csvPath
     * @param int $ignoreLines
     * @return array|bool
     */
    private function parseCSV($csvPath, $ignoreLines = 0) {

        ini_set('auto_detect_line_endings', true);
        $fileSystem = new Filesystem();

        if (!$fileSystem->exists($csvPath))
            return false;

        $rows = array();
        if (($handle = fopen($csvPath, "r")) !== false) {

            $i = 0;
            while (($data = fgetcsv($handle, null, ";")) !== false) {
                $i++;
                if ($ignoreLines && $i <= $ignoreLines) {
                    continue;
                }
                $rows[] = $data;
            }
            fclose($handle);
        }

        return $rows;
    }

    private function parseDate ($date) {

        $dateArr = explode("/", $date);
        if (count($dateArr) < 3)
            return null;

        return new Datetime("20".$dateArr[2]."-".$dateArr[1]."-".$dateArr[0]);
    }
}
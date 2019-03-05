<?php
namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;
class Fixtures extends Fixture
{
    private function importSql(ObjectManager $manager){
        $finder = new Finder();
        $finder->in(__DIR__ . '/sqls');
        $finder->name('*.sql');
        $finder->files();
        $finder->sortByName();
        foreach( $finder as $file ){
            print "Importing: {$file->getBasename()} " . PHP_EOL;
            $sql = $file->getContents();
            $sqls = explode("\n", $sql);
            foreach ($sqls as $query) {
                if ($query !=='') {
                    $manager->getConnection()->exec($query);
                }
            }
            $manager->flush();
        }
    }
    private function importProcedure(ObjectManager $manager){
        $finder = new Finder();
        $finder->in(__DIR__ . '/procedures');
        $finder->name('*.sql');
        $finder->files();
        $finder->sortByName();
        foreach( $finder as $file ){
            print "Importing Procedures: {$file->getBasename()} " . PHP_EOL;
            $sql = $file->getContents();
            $manager->getConnection()->exec($sql);
            $manager->flush();
        }
    }
    public function load(ObjectManager $manager)
    {
        $this->importSql($manager);
        $this->importProcedure($manager);
    }
}
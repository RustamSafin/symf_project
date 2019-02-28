<?php

namespace AppBundle\Command;


use AppBundle\Entity\Ad;
use AppBundle\Entity\Category;
use AppBundle\Entity\Test;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class BulkInsertCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:add-info')
            ->setDescription('Adds info to database')
            ->setHelp('This command allows you to...')
            ->addArgument('pages', InputArgument::REQUIRED, 'The number of pages you need to add.');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        for ($i = 1; $i < $input->getArgument('pages') ; $i++) {
//            $html = file_get_contents('https://www.avito.ru/tatarstan?p='.$i.'&s=101');
//            libxml_use_internal_errors(true);
//            $crawler = new Crawler($html);
//            libxml_use_internal_errors(false);
//
//            $nodeValues = $crawler->filter('div.item')->each(function (Crawler $node) {
//                $doctr = $this->getContainer()->get('doctrine');
//                $category = $doctr->getRepository(Category::class)->findOneByName($node->filter('div.data p')->first()->text());
//                $ad = new Ad();
//                $ad->setTitle($node->filter('h3.title a')->text());
//                $ad->setPrice($node->filter('div.about')->text());
//                if ($node->filter('div.description a')->text()) {
//                    $ad->setDescription($node->filter('div.description a')->text());
//                }
//                if (!$category) {
//                    $category = new Category();
//                    $category->setName($node->filter('div.data p')->first()->text());
//                    $doctr->getManager()->persist($category);
//                    $doctr->getManager()->flush();
//                }
//                $ad->setCategry($category);
//                $doctr->getManager()->persist($ad);
//                $doctr->getManager()->flush();
//
//                return $node->filter('div.description a')->text();
//            });
//        }


//        $metadata = $this->getContainer()->get('doctrine')->getManager()->getMetadataFactory()->getAllMetadata();$choices = '';
//        foreach ($metadata as $classMeta) {
//            $e = explode('\\',$classMeta->getName());
//            $choices .= strtolower(end($e)).'|';
//        }
//        dump(substr($choices,0,strlen($choices)-1));
//        $em = $this->getContainer()->get('doctrine')->getManager();
//        $metadata = $em->getMetadataFactory()->getAllMetadata();
//        $choice= '';
//        foreach ($metadata as $classMeta) {
//            if (preg_match('/.*Test$/',$classMeta->getName())){
//                $choice = $classMeta;
//                break;
//            }
//        }
//        $data = array('text'=>'petp', 'person'=>'krek');
//        $d=json_encode($data);
//        dump(is_array(json_decode($d)));
//        $data = json_decode($d,true);
//        $entity = $choice->getName();
//        $entity = new $entity();
//
//        $fields = $choice->getFieldNames();
//        foreach ($fields as $field) {
//            if (array_key_exists($field, $data)) {
//                $set = 'set' .ucfirst($field);
//                $entity->$set($data[$field]);
//            }
//        }

//        $em = $this->getContainer()->get('doctrine')->getManager();
//        $res = $em->getRepository(Test::class)->find('4');
//        dump($res);
//
//
//        $entity = 'admin/dashboard' ;
//       $router= $this->getContainer()->get('router')->getRouteCollection()->all();
//
//       $check1=0;
//        $check2=0;
//         $a=array();
//        foreach ($this->getContainer()->get('router')->getRouteCollection()->all() as $name => $route) {
//            $a[]=$route->getPath();
//
//        }
//
//        $check1 = preg_grep('/^\/[a-z]+(\/)?$/',$a);
//
//        dump($check1);
//        $check2 = preg_grep('/^\/\{[a-z]+\}(\/|(\/\{[a-z]+\}))?$/',$a);
//        dump($check2);
//        if (count($check1)>1||count($check2)>1) {
//            dump('ssss');
//        }
//
//        }
//        $a=$this->getContainer()->get('router')->getRouteCollection()->all();

//        dump($a);
//        $data = array('text'=>'petp');
//        $d=json_encode($data);
//        dump(is_array(json_decode($d)));
        $command = $this->getApplication()->find('doctrine:cache:clear-query');
        $arguments = array(
            'command' => 'doctrine:cache:clear-query',
        );
        $returnCode = $command->run(new ArrayInput($arguments), $output);
        $output->writeln("done");

    }


}
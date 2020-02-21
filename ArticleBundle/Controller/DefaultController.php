<?php

namespace ArticleBundle\Controller;


use ArticleBundle\ArticleBundle;
use ArticleBundle\Entity\Annonce;
use ArticleBundle\Entity\Statistique;
use ArticleBundle\Form\AnnonceType;
use ArticleBundle\Form\CategorieType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ArticleBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation\Article;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;


class DefaultController extends Controller
{
    /**
     * @Route("/AjouterCategorie",name="AjouterCategorie")
     */
    public function createAction(Request $request)
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);

        $form = $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

        }
        return $this->render('@Article/Default/AjouterCategorie.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/ConsulterCategorie",name="ConsulterCategorie")
     */

    public function ConsulterAction()
    {
        $projets = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('@Article/Default/Categorie.html.twig', array(
            'projets' => $projets
        ));
    }

    /**
     * @Route("/UpdateCategorie{id}",name="UpdateCategorie")
     */

    public function UpdateCategorieAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository(Categorie::class)->find($id);
        if ($request->isMethod('POST')) {

            $modele->setType($request->get('type'));
            $em->flush();
            return $this->redirectToRoute('ConsulterCategorie');
        }

        return $this->render('@Article/Default/UpdateCategorie.html.twig', array(
            'modele' => $modele

        ));
    }

    /**
     * @Route("/deleteCategorie{id}",name="deleteCategorie")
     */
    public function deleteCategorieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Categorie = $em->getRepository(Categorie::class)->find($id);
        $em->remove($Categorie);
        $em->flush();
        return $this->redirectToRoute("ConsulterCategorie");
    }

    /**
     * @Route("/AjoutAnnonce",name="AjoutAnnonce")
     */

    public function AjoutAnnonceAction(Request $request)
    {
        $annonce = new Annonce();

        $form = $this->createForm(AnnonceType::class, $annonce);

        $form = $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file =  $annonce->getPhoto();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $pathfile=$this->container->getParameter('pathmedia');


            $file->move(

                $pathfile,
                $fileName
            );
            $annonce->setPhoto($fileName);
            $em->persist($annonce);
            $em->flush();

        }
        return $this->render('@Article/Default/AjoutAnnonce.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/ConsulterAnnonce",name="ConsulterAnnonce")
     */

    public function ConsulterAnnonceAction()
    {
        $annonces = $this->getDoctrine()->getRepository(Annonce::class)->findAll();
        return $this->render('@Article/Default/Annonce.html.twig', array(
            'annonces' => $annonces
        ));
    }

    /**
     * @Route("/ModifierAnnonce{id}",name="ModifierAnnonce")
     */

    public function ModifierAnnonceAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $modele = $em->getRepository(Annonce::class)->find($id);
        if ($request->isMethod('POST')) {

            $modele->setNomArticle($request->get('NomArticle'));
            $modele->setDescription($request->get('Description'));
            $modele->setphoto($request->get('photo'));


            $em->flush();
            return $this->redirectToRoute('ConsulterAnnonce');
        }

        return $this->render('@Article/Default/ModifierAnnonce.html.twig', array(
            'modele' => $modele

        ));
    }

    /**
     * @Route("/SupprimerAnnonce{id}",name="SupprimerAnnonce")
     */

    public function SupprimerAnnonceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository(Annonce::class)->find($id);
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute("ConsulterAnnonce");
    }


    /**
     * @Route("/Annonces",name="Annonces")
     */

    public function AnnoncesAction()
    {
        $annonces = $this->getDoctrine()->getRepository(Annonce::class)->findAll();
        return $this->render('@Article/Default/Annonces.html.twig', array(
            'annonces' => $annonces
        ));
    }

    /**
     * @Route("/Statistique",name="Statistique")
     */


    public function StatistiqueAction()
    {

        $data=$this->getDoctrine()->getRepository(Statistique::class)->find(47);
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Annonce', 'Categories'],
                ['Nbannonce',   (int)  $data->getNbannonce()],
              ['categorie',   (string)  $data->getCategorie()->getNom()],

            ]
        );
        $histogram = new Histogram();
        $histogram->getData()->setArrayToDataTable([
            [''],
            [ $data->getNbannonce()],

            [100000000],
            [1000000000],
            [25000000],
            [600000],
            [6000000],
            [65000000],
            [210000000],
            [80000000],
        ]);
        $histogram->getOptions()->setTitle('Statistique');

        $histogram->getOptions()->setHeight(500);
        $histogram->getOptions()->getLegend()->setPosition('none');
        $histogram->getOptions()->setColors(['#e7711c']);
        $histogram->getOptions()->getHistogram()->setLastBucketPercentile(10);
        $histogram->getOptions()->getHistogram()->setBucketSize(10000000);

        return $this->render('@Article/default/Statistique.html.twig', array('pieChart' => $pieChart, 'histogram' => $histogram));

    }

    /**
     * @Route("/Search",name="Search")
     */

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $posts =  $em->getRepository('ArticleBundle:Annonce')->findEntitiesByString($requestString);
        $post =  $em->getRepository('ArticleBundle:Annonce')->findDescByString($requestString);
        $date =  $em->getRepository('ArticleBundle:Annonce')->findDateByString($requestString);
        if(!$posts) {
            $result['posts']['error'] = "Annonce Not found 😞 ";
        } else {
            $result['posts'] = $this->getRealEntities($posts);
        }
        if(!$post) {
            $result['posts']['error'] = "Annonce Not found 😞 ";
        } else {
            $result['posts'] = $this->getRealEntities($post);
        }
        if(!$date) {
            $result['posts']['error'] = "Annonce Not found 😞 ";
        } else {
            $result['posts'] = $this->getRealEntities($date);
        }
        return new Response(json_encode($result));


    }
    public function getRealEntities($posts){
        foreach ($posts as $posts){
            $realEntities[$posts->getId()] = [$posts->getPhoto(),$posts->getNomArticle(),];

        }
        foreach ($posts as $post) {
            $realEntities[$post->getId()] = [$post->getPhoto(), $post->getNomArticle(),];
        }
        foreach ($posts as $date) {
            $realEntities[$date->getId()] = [$date->getPhoto(), $date->getNomArticle(),];
        }
        return $realEntities;
    }

}

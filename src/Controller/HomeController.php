<?php

namespace App\Controller;

use App\Utilitaire\RestListing;
use App\Utilitaire\RestListingCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utilitaire\RestMariage;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        // Permet l'affichage des styles de mariages
        $mariages = RestMariage::getLesMariages($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        // Permet l'affichage des Top catégorie Wedder
        $categories = RestListingCategory::getLesListinCategory($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));
        
        // Permet l'affichage des dernier Wedder
        $listing = RestListing::getLesListing($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'));

        //dump($categories);
        
        return $this->render('home/index.html.twig', ['mariages' => $mariages, 'categories' => $categories, 'listing' => $listing]);
    }
    
    /**
     * @Route("/recherche/", name="recherche")
     */
    public function recherche(Request $request): Response
    {
        $erreur = null;
        $listings = [];
        
        $recherche = $request->get("rechercheInput");
        $lieu = $request->get("lieuInput");

        // Vérifie si un l'utilisateur à saisie quelque chose dans la barre de recherche
        if($request->isMethod("POST")){

            if(!empty($recherche) || !empty($lieu)){


                $listings = RestListing::getLesListingRecherche($this->client, $this->getParameter('apiAdress'), $this->getParameter('apiServer'), $recherche, $lieu);
                if(count($listings) <= 0){
                    $erreur = "Aucun résultat ne correspond à votre recherche";
                }

            }else{
                return $this->redirectToRoute("home");
            }

        }else{
            return $this->redirectToRoute("home");
        }

        return $this->render('recherche/index.html.twig', ["listings" => $listings, "recherche" => $recherche, "erreur" => $erreur, "lieu" => $lieu]);
    }


}

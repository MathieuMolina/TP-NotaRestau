<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\RestaurantRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function showBestRestaurant(RestaurantRepository $restaurant): Response
    {
        $restaurants = $restaurant->findAll();
        dump($restaurants);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'restaurant' => $restaurants
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function showBestRestaurant(RestaurantRepository $RestaurantRepository): Response
    {
        $restaurants = [];
        $restaurants = $RestaurantRepository->findAll();

        return $this->render('home/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }
}

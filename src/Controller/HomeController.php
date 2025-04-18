<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/applications', name: 'app_home_applications')]
    public function applications(): Response
    {
        return $this->render('home/applications.html.twig');
    }

    #[Route('/prestations', name: 'app_home_prestations')]
    public function prestations(): Response
    {
        return $this->render('home/prestations.html.twig');
    }
}

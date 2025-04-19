<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/prestations', name: 'app_home_prestations', methods: ['GET', 'POST'])]
    public function prestations(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message, [
            'action' => $this->generateUrl('app_message_new'),
        ]);

        return $this->render('home/prestations.html.twig', [
            'form' => $form,
        ]);
    }
}

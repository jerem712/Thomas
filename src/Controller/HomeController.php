<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    public function __construct(protected string $mercurePublicUrl) {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home.html.twig', []);
    }
}
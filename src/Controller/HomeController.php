<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;

class HomeController extends AbstractController
{
    public function __construct(protected string $mercurePublicUrl) {
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home.html.twig', []);
    }

    #[Route('/categ_{id}', name: 'categ')]

    public function category(int $id, ProductRepository $repo): Response
    {
        $products = $repo->findAll();
        $twig = 'categ_' . strval($id) . '.html.twig';
        return $this->render($twig, [
            'products' => $products,
        ]);
    }

    #[Route('/new_product', name: 'creation_product')]
    public function creation(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('app_burger');
        }

        return $this->render('ajout_product.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
}
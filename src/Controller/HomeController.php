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
use App\Repository\CategoryRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class HomeController extends AbstractController
{
    public function __construct(protected string $mercurePublicUrl) {
    }

    #[Route('/', name: 'home')]
    public function index(CategoryRepository $repo): Response
    {
        $categ = count($repo->findAll());
        $mail = $this->getUser();
        if($mail!=null) {
            $username = $mail->getUserIdentifier();
        }else {
            $username = " ";
        }
    
        return $this->render('home.html.twig', [
            'nb_categ' => $categ,
            'username' => $username,
        ]);
    }

    #[Route('/categ_{id}', name: 'categ')]

    public function category(int $id, ProductRepository $prepo, CategoryRepository $repo): Response
    {
        $twig = 'categ_' . strval($id) . '.html.twig';
        $categ = $repo->findAllId();
        $nb_categ = count($repo->findAll());
        $id_2 = $categ[$id - 1];
        $products = $prepo->findByCategory($id_2);
        return $this->render($twig, [
            'products' => $products,
            'nb_categ' => $nb_categ,
            'id' => $id,
        ]);
    }

    #[Route('/list_product_{categ}', name: 'list_product')]
    public function list(?string $categ = null, ProductRepository $prepo, CategoryRepository $repo): Response
    {
        if($categ == 0) {
            $products = $prepo->findAll();
            $nb_products = count($products);
        } else {
            $categ_Id = $repo->findAllId();
            $id_2 = $categ_Id[$categ - 1];
            $products = $prepo->findByCategory($id_2);
            $nb_products = count($products);
        }
        $nb_categ = count($repo->findAll());

        return $this->render('list_product.html.twig', [
            'nb_categ' => $nb_categ,
            'products' => $products,
            'nb_products' => $nb_products,
            'categ_name' => $categ,
        ]);
    }

    #[Route('/new_product', name: 'new_product')]
    public function creation(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($product);
                $em->flush();
                return $this->redirectToRoute('home');
        }

        return $this->render('ajout_product.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
}
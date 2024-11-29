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
use Knp\Component\Pager\PaginatorInterface;

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

    public function category(int $id, PaginatorInterface $paginator, Request $request, ProductRepository $prepo, CategoryRepository $repo): Response
    {
        //$twig = 'categ_' . strval($id) . '.html.twig';
        $categ = $repo->findAllId();
        $nb_categ = count($repo->findAll());
        $id_2 = $categ[$id - 1];
        $products = $prepo->findByCategory($id_2);
        $query = $prepo->findByCategoryQuery($id_2);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            3 /* limit per page */
        );
        return $this->render('categ.html.twig', [
            'products' => $products,
            'nb_categ' => $nb_categ,
            'id' => $id,
            'pagination' => $pagination
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
    public function creation(Request $request, EntityManagerInterface $em, CategoryRepository $repo): Response
    {
        $nb_categ = count($repo->findAll());
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
            'nb_categ' => $nb_categ,
        ]);
    }

    #[Route('/delete_{id}', name: 'delete')]
    public function delete(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $product = $em->getRepository(Product::class)->find($id);

        if(!$product)
        {
            throw $this->createNotFoundException('The product does not exist');
        }

        $em->remove($product);
        $em->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }

    #[Route('/add_basket_{id}', name: 'delete')]
    public function add(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $product = $em->getRepository(Product::class)->find($id);

        if(!$product)
        {
            throw $this->createNotFoundException('The product does not exist');
        }

        $em->remove($product);
        $em->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }
}
<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\OrderItemRepository;
use App\Repository\OrderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @method User|null getUser()
 */

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

    public function category(int $id, PaginatorInterface $paginator, Request $request, ProductRepository $prepo, CategoryRepository $repo, OrderRepository $orderrepo): Response
    {
        $usercart = $orderrepo->findByUser($this->getUser());
        $cart = [];
        if($usercart != null) {
            foreach($usercart->getOrderItem() as $item) {
                $cart[] = $item->getProduct();
            }
        }
        $categ = $repo->findAllId();
        $nb_categ = count($repo->findAll());
        $id_2 = $categ[$id - 1];
        $products = $prepo->findByCategory($id_2);
        foreach($products as $p) {
            if(($key = array_search($p, $cart)) !== false) {
                unset($products[$key]);
            }
        }
        $pagination = $paginator->paginate(
            $products, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            3 /* limit per page */
        );
        
        dump($pagination);
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
    
    #[Route('/detail_{id}', name: 'detail')]
    public function detail(int $id, Request $request, ProductRepository $prepo, CategoryRepository $repo): Response
    {
        $product = $prepo->findById($id);
        $nb_categ = count($repo->findAll());

        dump($product);

        return $this->render('detail.html.twig', [
            'product' => $product,
            'nb_categ' => $nb_categ,
        ]);
    }

    #[Route('/addCart_{id}', name: 'addCart')]
    public function addCart(int $id, ProductRepository $repo, EntityManagerInterface $manager, Request $request, OrderRepository $orderrepo): Response
    {
        $usercart = $orderrepo->findByUser($this->getUser());
        if($usercart == null) {
            $order = new Order();
            $order->setUser($this->getUser());
            $manager->persist($order);
            $manager->flush();
            $usercart = $order;
        }
        
        $orderitem = new OrderItem();
        $orderitem->setProduct($repo->findById($id))
            ->setQuantity(1)
            ->setOrders($usercart)
            ->setProductPrice($repo->findById($id)->getPrice());
        $manager->persist($orderitem);
        $manager->flush();

        $usercart->addOrderItem($orderitem);
        $manager->persist($usercart);
        $manager->flush();

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }

    #[Route('/Cart', name: 'seeCart')]
    public function Cart(CategoryRepository $repo, EntityManagerInterface $manager, Request $request, OrderRepository $orderrepo): Response
    {
        $orderitems = $orderrepo->findByUser($this->getUser());
        $nb_categ = count($repo->findAll());

        dump($orderitems);

        return $this->render('cart.html.twig', [
            'items' => $orderitems,
            'nb_categ' => $nb_categ,
        ]);
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
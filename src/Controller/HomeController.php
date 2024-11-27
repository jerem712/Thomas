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

    #[Route('/list_product', name: 'list_product')]
    public function list(CategoryRepository $repo): Response
    {
        $nb_categ = count($repo->findAll());

        return $this->render('list_product.html.twig', [
            'nb_categ' => $nb_categ,
        ]);
    }

    #[Route('/new_product', name: 'new_product')]
    public function creation(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('Image')->getData();
            echo $imageFile;

            // this condition is needed because the 'image' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move("var\www\symfony\assets\images", $newFilename);
                } catch (FileException $e) {
                    echo "test";
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $product->setImage($newFilename);
                $em->persist($product);
                $em->flush();
                return $this->redirectToRoute('home');
            }
        }

        return $this->render('ajout_product.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
}
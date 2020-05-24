<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpKernel\Event\ControllerEvent;


/**
 * @Route("/shop", name="shop_")
 */
class ShopController extends AbstractController
{
    private Cart $cart;

    /** shows list of product that are saved in the database
     * @Route("/", name="list")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function list(ProductRepository $productRepository)
    {
        //creates a global cart object and saves it in session
        $session = $this->get('session');
        if($session->get('cart') == null) {
            $session->set('cart', new Cart());
        }
        else  $this->cart = $session->get('cart');

        $products = $productRepository->findAll();
        return $this->render('shop/list.html.twig', [
            'products' => $products
        ]);
    }

    /** adds product to Cart object and updates the session variable
     * @Route("/add/{id}", name="add")
     * @param Product $product
     * @return RedirectResponse
     */
    public function addToCart(Product $product) {
        $session = $this->get('session');
        $this->cart = $session->get('cart');

        $num = $this->cart->addProduct($product);
       // $this->get('twig')->addGlobal('cart_count',2);

        $session->set('cart', $this->cart);

        $this->addFlash('success', "Product was added to cart");

        return $this->redirect($this->generateUrl('shop_list'));
    }


}

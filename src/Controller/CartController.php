<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Product;
use App\Form\FormType;
use BenMajor\ExchangeRatesAPI\Exception;
use BenMajor\ExchangeRatesAPI\ExchangeRatesAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private Cart $cart;
    /**
     * @Route("/cart", name="cart")
     */
    public function index()
    {
        $session = $this->get('session');

        if($session->get('cart') == null) {
            $session->set('cart', new Cart());
        }
        else  $this->cart = $session->get('cart');

        return $this->render('cart/index.html.twig', [
            'cart' => $this->cart,
        ]);
    }

    /**
     * removes product from Cart object
     * @Route("/rem/{id}", name="remove")
     * @param Product $product
     */
    public function remove(Product $product) {
        $this->cart = $this->get('session')->get('cart');
        $this->addFlash('success', "Product was successfully removed from cart");

        $this->cart->removeProduct($product);
        return $this->redirect($this->generateUrl('cart'));
    }

    /**
     * increases the quantity of object in Cart by one
     * @Route("/inc/{id}", name="inc")
     * @param Product $product
     */
    public function incrementQuantity(Product $product) {
        $this->cart = $this->get('session')->get('cart');

        $this->cart->incrementQuantity($product);
        return $this->redirect($this->generateUrl('cart'));
    }

    /**
     * decreases the quantity of object in Cart by one
     * @Route("/dec/{id}", name="dec")
     * @param Product $product
     */
    public function decrementQuantity(Product $product) {
        $this->cart = $this->get('session')->get('cart');

        $this->cart->decrementQuantity($product);
        return $this->redirect($this->generateUrl('cart'));
    }

    /**
     * @Route("/count", name="count")
     * @return int
     */
    public function count() {
        $session = $this->get('session');

        if($session->get('cart') == null) {
            $session->set('cart', new Cart());
        }

        else  $this->cart = $session->get('cart');

        if($this->cart == null) {
            return 0;
        }
        else return $this->cart->getCount();
    }

}

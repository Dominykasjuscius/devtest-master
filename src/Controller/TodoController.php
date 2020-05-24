<?php

namespace App\Controller;

use App\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */

    public function index()
    {

        return $this->redirectToRoute('todo');
    }

    /**
     * @Route("/todo", name="todo")
     */
    public function todo()
    {
        return $this->render('todo/index.html.twig');
    }
}

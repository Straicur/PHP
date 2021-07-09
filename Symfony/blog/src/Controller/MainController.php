<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this -> render('home/index.html.twig');
        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/MainController.php',
        // ]);
    }
    /**
     * @Route("/custom/{name?}", name="custom")
     * @param Request $request
     * @return Response
     */
     public function custom(Request $request)//: Response
    {
        $name = $request->get('name');
        // return new Response('<h1>Witaj: '.$name.'</h1>');
        return $this -> render('home/custom.html.twig',['name'=>$name]);
    }
}

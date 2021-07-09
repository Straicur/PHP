<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/post", name="post.")
*/
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository) 
    {
        $post= $postRepository->findAll();
        //dump($post);
        return $this->render('post/index.html.twig', [
            'post'=>$post
        ]);
    }
    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post){
        //dump($post);die;
        //$id,PostRepository $postRepository
        // $post=$postRepository->findPostWithCategory($id);
        //jeśli chcesz tworzyć customowe query to musisz zmienic view 
        // dump($post);
        return $this->render('post/show.html.twig',[
            'post'=> $post
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function remove(Post $post){
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        $this->addFlash('success','Post was removed');
        return $this->redirect($this->generateUrl('post.index'));
    }
     /**
     * @Route("/create", name="create")
     *  * @param Request $request
     * @return Response
     */
    public function create(Request $request ,FileUploader $fileUploader){
        $post= new Post();
        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        //$form->getErrors();
        if($form->isSubmitted())//&& $form->isValid()
        {
            $em = $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */
            $file = $request->files->get('post')['image'];  
            //dump($file);dump($request->files->get('post')['image']);die;
            if($file){
                $filename=$fileUploader->uploadFile($file);
                $post->setImage($filename);
            }
            
            $em->persist($post);
            $em->flush();
            return $this->redirect($this->generateUrl('post.index'));
        }
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($post);
        // $em->flush();
        return $this->render('post/create.html.twig',[
            'form'=> $form->createView()
        ]);
    }
    
}

<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Articulo; 
use App\form\ArticuloType;


class ArticuloController extends AbstractController
{
    /**
     * @Route("/" , name="/")
     */
    public function paginaInicio(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Articulo::class);
        $articulos = $repository->findAll();


        return $this->render('home.html.twig', [
            "articulos" => $articulos
        ]);
    }


    /**
     * @Route("/ver/{numero}")
     */
    public function inforArticulo(ManagerRegistry $doctrine, $numero) {

        $repository = $doctrine->getRepository(Articulo::class);
        $articulo = $repository->findOneBy([
            "id" => $numero
        ]);

        return $this->render('ver.html.twig', [
            "articulo" => $articulo            
        ]);
    }


    /**
     * @Route("crear", name="crear")
     */
    public function new(Request $request,ManagerRegistry $doctrine): Response
    {
        
        // creates a task object and initializes some data for this example
        $articulo = new Articulo();

        $form = $this->createForm(ArticuloType::class,$articulo);
        $entityManager=$doctrine->getManager();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $articulo = $form->getData();

                $entityManager->persist($articulo);
                $entityManager->flush();

             return $this->redirectToRoute('/', [
                'form' => $form]);
            }
        
            return $this->renderForm('form.html.twig', ['form' => $form]);
           
    }


    /**
     * @Route("editar/{numero}", name="editar")
     */
    public function edit(Request $request,ManagerRegistry $doctrine,int $numero): Response
    {
        
        $articuloEncontrado = $doctrine->getRepository(Articulo::class)->find($numero);
        $entityManager =$doctrine->getManager();

        if (!$articuloEncontrado) {
            throw $this->createNotFoundException('No existe ningun articulo con el id:  ' . $numero);
        } 
        
        $form = $this->createForm(ArticuloType::class , $articuloEncontrado);
        $entityManager=$doctrine->getManager();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articuloEcontrado=$form->getData();
            $entityManager->persist($articuloEcontrado);
            $entityManager->flush();

            return $this->redirectToRoute('/');
        }    
            return $this->renderform('editar.html.twig', ['form' => $form]);    
    
       
    }


    /**
     * @Route("eliminar/{numero}", name="eliminar")
     */
    public function eliminar(Request $request,ManagerRegistry $doctrine, int $numero) {

  
        $articuloBorrado = $doctrine->getRepository(Articulo::class)->find($numero);
        $entityManager =$doctrine->getManager();

        if (!$articuloBorrado) {
            throw $this->createNotFoundException('No existe ningun articulo con el id:  ' . $numero);
        } 
            $entityManager->remove($articuloBorrado);
            $entityManager->flush();

            return $this->redirectToRoute('/');
        }    
    
    }

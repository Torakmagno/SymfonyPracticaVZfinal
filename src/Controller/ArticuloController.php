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
    public function new(Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $articulo = new Articulo();
        

        $form = $this->createFormBuilder($articulo)
            ->add('id', NumberType::class)
            ->add('titulo', TextType::class)
            ->add('fecha', DateType::class)
            ->add('texto', TextType::class)
            ->add('comentario', TextType::class)
            ->add('resumen', TextType::class)
            ->add('categoria', TextType::class)
            ->add('url', TextType::class)
            ->add('medio', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();


            return $this->renderForm('form.html.twig', [
                'form' => $form,
            ]);
    }

}
<?php
namespace App\form;

use App\Entity\Articulo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ArticuloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('fecha')
            ->add('texto') 
            ->add('comentario')
            ->add('resumen')
            ->add('categoria' , ChoiceType::class, [
                'choices' => [
                    ' Opinión'=> 'opinión',
                    'Divulgación'=> ' divulgación',
                    ' Informativo'=> 'informativo',
                    ' Reportaje'=> 'reportaje',
                    ' Editorial'=> 'editorial',
                    ' Columna'=> 'columna',
                    ' Entrevista'=> 'entrevista',
                    ' Critica'=> 'critica',
                    ' Otros'=> 'otros',

                ]
            ])
            ->add('url')
            ->add('medio' , ChoiceType::class, [
                'choices' =>[
                    'Papel'=> 'papel',
                    'Digital'=> 'digital'
                ]
            ])
            ->add('guarda', SubmitType::class);
}

            public function configureOptions(OptionsResolver $resolver): void {

                $resolver->setDefaults([
                    'data_class' => Articulo::class,
                ]);
            }


                }

<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Category;
class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
                ])
            ->add('description',TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
                ])
            ->add('image',FileType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ]
            ]
            )//jeśli chcesz uzyc innej nazwy niz image dodaj 3 arg['mapped=>false']
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('save',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-primary float-right mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}

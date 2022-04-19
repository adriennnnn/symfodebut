<?php

namespace App\Form;

use App\Entity\Campaign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label'=> 'Title',
                'attr'=> ['placeholder' => 'Titre de la campaign'
                ]
            ])
            ->add('content', TextareaType::class,[
                'label'=> 'Contenu',
                'attr'=> ['placeholder' => 'Contenue'
                ]
                ])
            ->add('goal', NumberType::class,[
                'label'=> 'Objectif',
                'attr'=> ['placeholder' => 'Objectif'
                ]
                ])
            ->add('name', TextType::class,[
                'label'=> 'Nom',
                'attr'=> ['placeholder' => 'Nom'
                ]
                ])
            ->add('email', TextType::class,[
                'label'=> 'Mail',
                'attr'=> ['placeholder' => 'Entrez votre Email !'
                ]
                ])
        ;
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campaign::class,
        ]);
    }
}

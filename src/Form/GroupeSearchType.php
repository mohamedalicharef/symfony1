<?php

namespace App\Form;

use App\Entity\Groupe;
use App\Entity\GroupeSearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('groupe',EntityType::class,['class' => Groupe::class, 'choice_label' => 'libelle' , 'label' => 'Groupe' ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupeSearch::class,
        ]);
    }
}

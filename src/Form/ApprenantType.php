<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Apprenant;
use App\Entity\Groupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApprenantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('nom')
            ->add('tel')
            ->add('pass')
            ->add('dareNaissance',TextType::class, ['label'=>'Date de Naissance',])
            ->add('sexe', TextType::class, ['label'=>'genre',
        //,
                //ChoiceType::class, [
               // 'choice'=>[
                //    ' '=>0,
                //    'M'=>1,
                //    'F'=>2,
               // ],

            ])
            ->add('etatCompte')
            ->add('photo')
            ->add('role')
            ->add('cin')
            ->add('password')
            ->add('groupe',EntityType::class,['class'=>Groupe::class, 'choice_label'=>'libelle', 'label'=>'Groupe'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Apprenant::class,
        ]);
    }
}

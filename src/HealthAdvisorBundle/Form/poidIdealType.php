<?php

namespace HealthAdvisorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class poidIdealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod("GET")
            ->add('taille')
            ->add('sexe',ChoiceType::class,array('choices'
            =>array('Homme'=>'Homme','Femme'=>'Femme')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'health_advisor_bundlepoid_ideal_type';
    }
}

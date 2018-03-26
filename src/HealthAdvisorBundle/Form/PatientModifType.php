<?php

namespace HealthAdvisorBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cinUser',EntityType::class,array('label'=>'nom',
                       'class'=>'HealthAdvisorBundle:Utilisateur',
                       'multiple'=>false))
            ->add('cinUser',EntityType::class,array('choice_label'=>'prenom',
                'class'=>'HealthAdvisorBundle:Utilisateur',
                'multiple'=>false))
            ->add('cinUser',EntityType::class,array('choice_label'=>'dateNaiss',
                'class'=>'HealthAdvisorBundle:Utilisateur',
                'multiple'=>false))
            ->add('cinUser',EntityType::class,array('choice_label'=>'pays',
                'class'=>'HealthAdvisorBundle:Utilisateur',
                'multiple'=>false))
            ->add('cinUser',EntityType::class,array('choice_label'=>'ville',
                'class'=>'HealthAdvisorBundle:Utilisateur',
                'multiple'=>false))
            ->add('cinUser',EntityType::class,array('choice_label'=>'numTel',
                'class'=>'HealthAdvisorBundle:Utilisateur',
                'multiple'=>false))
            ->add('photoProfile');

    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'health_advisor_bundle_patient_modif_type';
    }
}

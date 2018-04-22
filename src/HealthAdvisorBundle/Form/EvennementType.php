<?php

namespace HealthAdvisorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvennementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
                ->add('date',TextType::class)
                ->add('location')
                ->add('type',ChoiceType::class,array('choices' => array('Conférence' => 'Conférence', 'Evénement sportif' => 'Evénement sportif','Dépistage' => 'Dépistage','Sensibilisation' => 'Sensibilisation')))
                ->add('maxParticipants')
                ->add('description')
                ->add('heure', TextType::class)
                ->add('Valider',SubmitType::class)
                ->setMethod('POST');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HealthAdvisorBundle\Entity\Evennement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'healthadvisorbundle_evennement';
    }


}

<?php

namespace HealthAdvisorBundle\Form;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlimentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomAliment')
            ->add('quantite')
            ->add('valeurEnergetique')
            ->add('typeAliment')
            ->add('ajouter',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HealthAdvisorBundle\Entity\Aliment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'healthadvisorbundle_aliment';
    }


}

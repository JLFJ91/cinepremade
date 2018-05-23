<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre')
            ->add('apellidos')
            ->add('img')
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción'
            ])
            ->add('email')
            ->add('facebook')
            ->add('instagram')
            ->add('twitter')
            ->add('youtube')
            ->add('tipo', ChoiceType::class, [
                'choices' => [
                    'Selecciona uno...' => '',
                    'Fundador' => 'fundador',
                    'Socio' => 'socio'
                ]
            ])
            ->add('proyectos', EntityType::class, [
                'class' => 'AppBundle:Proyecto',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nombre', 'ASC');
                },
                'multiple' => true,
                'required' => false
            ])
            ->add('tags', EntityType::class, [
                'class' => 'AppBundle:Tag',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.tag', 'ASC');
                },
                'multiple' => true,
                'required' => false
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Equipo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_equipo';
    }


}

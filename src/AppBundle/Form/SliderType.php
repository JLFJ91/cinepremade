<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titulo')
            ->add('contenido')
            ->add('tipo', ChoiceType::class, [
                'choices' => [
                    'Selecciona uno...' => '',
                    'Imagen' => 'image',
                    'Video' => 'video'
                ]
            ])
            ->add('url', TextType::class, [
                'label' => 'Id Video / Imagen'
            ])
            ->add('overlay', ChoiceType::class, [
                'choices' => [
                    'Si' => true,
                    'No' => false
                ]
            ])
            ->add('textColor', TextType::class, [
                'label' => 'Color del texto'
            ])
            ->add('textAlign', ChoiceType::class, [
                'label' => 'Alineación del texto',
                'choices' => [
                    'Derecha' => 'right',
                    'Izquierda' => 'left',
                    'Centro' => 'center'
                ]
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Slider'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_slider';
    }


}

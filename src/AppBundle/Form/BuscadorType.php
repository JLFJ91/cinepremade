<?php

namespace AppBundle\Form;


use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BuscadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tag', EntityType::class, [
                'class' => 'AppBundle:Tag',
                'label' => 'Filtrar socios por Categoría',
                'label_attr' => ['class' => 'h5 mb-3'],
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.tag', 'ASC');
                },
                'required' => true,
                'placeholder' => 'Selecciona todos...',
                'choice_label' => 'tag',
                'required' => false
            ]);
    }

}
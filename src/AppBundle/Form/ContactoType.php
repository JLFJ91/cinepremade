<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/04/2018
 * Time: 13:15
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => 'Nombre'
            ])
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('mensaje', TextareaType::class, [
                'label' => 'Mensaje'
            ]);
    }

}
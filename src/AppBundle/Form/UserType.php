<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name',TextType::class,array('label'=>'First Name:','required'=>true,
            'attr'=>array('class'=>'form-control')))->
        add('lastname', TextType::class, array(
            'label'=>'Last Name:',
            'required'=>true,
            'attr'=>array('class'=>'form-control')
        ))
            ->add('username',TextType::class,array(
                'label'=>'Username:',
                'required'=>true,
                'attr'=>array('class'=>'form-control')
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password:','required'=>true,'attr'=>array('class'=>'form-control')),
                'second_options' => array('label' => 'Repeat Password:','required'=>true,'attr'=>array('class'=>'form-control')),
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}

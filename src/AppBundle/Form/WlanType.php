<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class WlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ssid', 'text', array(
                'label' => 'wlan.label.ssid',
                'required' => true,
            ))
            ->add('password', 'text', array(
                'label' => 'wlan.label.password',
                'required' => false,
            ))
            ->add('save', 'submit', array(
                'label' => 'wlan.button.add',
                'attr' => array('class' => 'button-primary')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Wlan'
        ));
    }

    public function getName()
    {
        return 'wlan';
    }
}

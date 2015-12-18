<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heartbeatUrl', 'text', array(
                'label' => 'admin.label.heartbeatUrl',
                'required' => true,
            ))
            ->add('printboxPid', 'text', array(
                'label' => 'admin.label.printboxPid',
                'required' => true,
            ))
            ->add('save', 'submit', array(
                'label' => 'basics.button.save',
                'attr' => array('class' => 'button-primary')
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Settings'
        ));
    }

    public function getName()
    {
        return 'settings';
    }
}

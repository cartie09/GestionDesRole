<?php

namespace boxiweb\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
               ->add('id')
               ->add('name')
                ->add('prename')
      ->add('roles', 'choice', array(
    'choices'   => array('ROLE_USER' => 'Utilisateur', 'ROLE_ADMIN' => 'Admin', 'ROLE_SUPER_ADMIN' => 'SuperAdmin'),
    'required'  => true,
    'multiple' => true
                ))
               
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'boxiweb\UserBundle\Entity\Group',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'group';
    }
}
//php app/console doctrine:mapping:import  "boxiwebUserBundle" xml
//php app/console doctrine:generate:entities boxiwebUserBundle
//
//php app/console pugx:generate:crud 
//--entity=boxiwebUserBundle:user \
//--layout=::base.html.twig \
//--theme=AppBundle:Form:bootstrap_3_layout.html.twig \
//--with-write --with-filter --with-sort --use-paginator \
//--route-prefix="admin/users"
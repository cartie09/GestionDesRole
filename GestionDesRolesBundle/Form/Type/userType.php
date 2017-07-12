<?php
namespace boxiweb\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use boxiweb\UserBundle\Entity\Group;
class userType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currentLocale="benevole";
        $builder
//           ->add('username')
                
//                  ->add('username', 'text', array( 
//            'label'  => 'username',
//            'attr'   =>  array(
//                'class'   => 'monlabel'),
//                      
//                      
//              'data'  => 'username',
//            'attr'   =>  array(
//                'class'   => 'moninput')        
//            )
//        )
             ->add('username', 'text', array(
        'label_attr' => array('class' => 'monlabel'),
        'attr'       => array('class' => 'moninput'),
    ))
                
                
//            ->add('usernameCanonical')
              
//            ->add('email')
//            ->add('emailCanonical')
//            ->add('enabled')
//            ->add('salt')
//            ->add('password')
//            ->add('lastLogin')
//            ->add('locked')
//            ->add('expired')
//            ->add('expiresAt')
//            ->add('confirmationToken')
//            ->add('passwordRequestedAt')
//            ->add('roles')
//            ->add('credentialsExpired')
//            ->add('credentialsExpireAt')
//            ->add('familyName')
//            ->add('lastName')
//            ->add('firstName')
//            ->add('tel')
//            ->add('created')
//            ->add('lastactivity')
//            ->add('nom')
//            ->add('prenom')
//           ->add('loginCount')
//          ->add('firstLogin')
                
                
                 
                  ->add('email', null, array(
                      'label' => "Nom dutilisateur",
        'label_attr' => array('class' => 'monlabel'),
        'attr'       => array('class' => 'moninput'),
    ))
//                
//          ->add('username', null, array('label' => "Nom d'utilisateur"))
//            ->add('email', null, array('required' => false, 'label' => 'E-mail'))
            ->add('plainPassword', 'repeated', array(
                
                'type' => 'password',
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'required' => $options['passwordRequired'],
                'first_options'  => array(
                    'label' => 'Mot de passe',
                    'label_attr' => array('class' => 'monlabel'),
        'attr'       => array('class' => 'moninput'),
                    
                    ),
                
                
                
                'second_options' => array('label' => 'Répétez le mot de passe'),
               
            ))
                ->add('groups', 'entity', array(
                'label' => 'Groupes',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'class' => 'boxiweb\UserBundle\Entity\Group',
//                 'label_attr' => array('class' => 'checkboxlabel'),    
//                 'attr'       => array('class' => 'moncheckbox'),   
                  
                    ))
                
                
        ;
                 
//                ->add('roles', 'collection', array(
//                'label' => 'Zones',
////                    'prototype_name'=>'roles',
//                'type' => new Group(),
//                'allow_add' => true,
//                'allow_delete' => true,
//                'by_reference' => false,
//                'required' => false 
//            ));
              
                
                
//            ->add('groups', 'entity', array(
//                'label' => 'Groupes',
////                'property'=> 'name',
//                'multiple' => true,
//                'expanded' => true,
//                'required' => false,
//                'class' => 'boxiweb\UserBundle\Entity\Group'));
        
                
              
//        -->add('roles', 'entity', array(  //acteurs avec s car $private acteurs
//'class' => 'boxiweb\UserBundle\Entity\Group',
//      'property' => 'name',
//      
//   
//));
//                
//                ->add('groups', 'entity', array(
//                'label' => 'Groupes',
//                'multiple' => true,
//                'expanded' => true,
//                'required' => false,
//                'class' => 'boxiweb\UserBundle\Entity\Group'))
//        ;
//               ->add('groups','entity',array
//                  (
//    'label' => 'groupes',
//              'class' => 'boxiweb\UserBundle\Entity\Group',
//              'property' => 'name',             
//                  )  )  ;
        
//        ->add('roles', 'choice', array(
//'choices'   => array(
//    'ROLE_ADMIN'   => 'ROLE_ADMIN',
//    'ROLE_USER' => 'ROLE_USER',
//),
//
//'multiple'  => true,
//));
//              ->add('roles', 'choice', array(
//'choices' => array('ROLE_USER' => 'Utilisateur', 'ROLE_ADMIN' => 'administrateur'),
//'multiple'=>true
//            ))  ;
                 
//                ->add('groups', 'entity', array(
//                   'type' => 'choice',
//                   'options' => array(
//                       'choices' => array(
//                           'ROLE_ADMIN' => 'Admin',
//                           'ROLE_EDITOR' => 'Editor'
//                       )
//                   )
//               )
//           );
        ;
        if ($options['lockedRequired']) {
            $builder->add('locked', null, array('required' => false, 
                'label' => 'Vérouiller le compte'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'boxiweb\UserBundle\Entity\user',
             'passwordRequired' => true,
            'lockedRequired' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }
}




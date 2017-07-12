<?php

namespace boxiweb\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class userFilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         ->add('username', null, array('label' => "Nom d'utilisateur"))
//            ->add('username', 'filter_text')
//            ->add('usernameCanonical', 'filter_text')
//            ->add('email', 'filter_text')
//            ->add('emailCanonical', 'filter_text')
////            ->add('enabled', 'filter_boolean')
//            ->add('salt', 'filter_text')
//            ->add('password', 'filter_text')
//            ->add('lastLogin', 'filter_date')
//            ->add('locked', 'filter_boolean')
//            ->add('expired', 'filter_boolean')
//            ->add('expiresAt', 'filter_date')
//            ->add('confirmationToken', 'filter_text')
//            ->add('passwordRequestedAt', 'filter_date')
//            ->add('roles', 'filter_text')
//            ->add('credentialsExpired', 'filter_boolean')
//            ->add('credentialsExpireAt', 'filter_date')
////            ->add('familyName', 'filter_text')
//            ->add('lastName', 'filter_text')
//            ->add('firstName', 'filter_text')
           ->add('tel', 'filter_text')
//            ->add('created', 'filter_date')
//            ->add('lastactivity', 'filter_date')
//            ->add('nom', 'filter_text')
//            ->add('prenom', 'filter_text')
//            ->add('loginCount', 'filter_number')
//            ->add('firstLogin', 'filter_date')
////            ->add('logement', 'filter_entity', array('class' => 'boxiweb\UserBundle\Entity\Logement'))
////            ->add('group', 'filter_entity', array('class' => 'boxiweb\UserBundle\Entity\Group'))
//                 ->add('email', 'filter_text', array('label' => 'E-mail'))
//                ->add('enabled', 'filter_boolean', array('label' => 'Autorisé'))
//                ->add('groups', 'filter_entity', array(
//                    'label' => 'Groupes',
//                    'class' => 'boxiweb\UserBundle\Entity\Group',
//                    'expanded' => true,
//                    'multiple' => true,
//                    'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
//                        $query = $filterQuery->getQueryBuilder();
//                        $query->leftJoin($field, 'm');
//                        // Filter results using orWhere matching ID
//                        foreach ($values['value'] as $value) {
//                            $query->orWhere($query->expr()->in('m.id', $value->getId()));
//                        }
//                    },
//                ))
//                 
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'boxiweb\UserBundle\Entity\user',
            'csrf_protection'   => false,
            'validation_groups' => array('filter'),
            'method'            => 'GET',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_filter';
    }
}

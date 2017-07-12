<?php
namespace boxiweb\UserBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 
class RegistrationType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {        
        $builder
                ->add('nom')
                ->add('prenom');
    }
    public function getName() {
        return 'boxiweb_user_registration';
    }
    public function getParent() {
        return "fos_user_registration"; 
    }
}

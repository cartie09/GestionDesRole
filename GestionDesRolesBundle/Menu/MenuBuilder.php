<?php

namespace boxiweb\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder extends ContainerAware {

    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory) {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack) {

        $menu = $this->factory->createItem('root');
//                $menu->addChild('entities', array(
//                    'label' => 'Gestion'
//                ))
//                ->setAttribute('dropdown', true)
//                ->setAttribute('icon', 'fa fa-list')
                ;
        $menu 
                ->addChild('users', array(
                    'route' => 'admin_users',
                    'label' => 'Utilisateurs'))
//                 ->setAttribute('nav', true)
                
                ;
 $menu 
                ->addChild('groups', array(
                    'route' => 'admin_groups',
                    'label' => 'Groupes'));
$menu->addChild('Se déconnecter', array('route' => 'fos_user_security_logout'))
                    ->setAttribute('icon', 'fa fa-unlink');
        
     //////////////////////// version dropdown//////////////////   
//        $menu->addChild('entities', array(
//                    'label' => 'Gestion'
//                ))
//                ->setAttribute('dropdown', true)
////                ->setAttribute('icon', 'fa fa-list')
//                ;
//        $menu['entities']
//                ->addChild('users', array(
//                    'route' => 'admin_users',
//                    'label' => 'Utilisateurs'))
////                 ->setAttribute('nav', true)
//                
//                ;
//
//        $menu['entities']
//                ->addChild('groups', array(
//                    'route' => 'admin_groups',
//                    'label' => 'Groupes'));
//                $menu['entities']->addChild('Changer mon mot de passe', array('route' => 'fos_user_change_password'));
//                
             //////////////////////// fin cersion dropdown//////////////////      
//                
//      
//                $menu['entities']->addChild('S\'inscrire', array('route' => 'fos_user_registration_register'));       
//                $menu['Home']->addChild('Menu1', array('route' => '_mapage1'));
//                $menu['Home']->addChild('Menu2', array('route' => '_mapage2'));
//                
//                $menu->addChild('Categorie1', array('route' => 'homepage'));
//                $menu['Categorie1']->addChild('Menu1', array('route' => 'fos_user_security_login'));
//                $menu['Categorie1']->addChild('Menu2', array('route' => 'fos_user_security_logout'));

        return $menu;
    }

    public function buildUserMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav no-borders navbar-right');

        $context = $this->container->get('security.context');
        if ($context->isGranted('ROLE_ADMIN')) {

            $menu->addChild('profile', array(
                        'label' => $context->getToken()->getUser()->getUsername()))
                    ->setAttribute('dropdown', true)
                    ->setAttribute('icon', 'fa fa-user');

            $menu['profile']->addChild('Se déconnecter', array('route' => 'fos_user_security_logout'))
                    ->setAttribute('icon', 'fa fa-unlink');
            $menu['profile']->addChild("Se connecter sous un autre profil", array('route' => 'fos_user_security_login'))
                    ->setAttribute('icon', 'fa fa-link');
        }
        
        elseif ($context->isGranted('ROLE_USER'))
        {
             
      
                   $menu['entities']->addChild('Changer mon mot de passe', array('route' => 'fos_user_change_password'));      
             }
              else
        {
             
      
                $menu['entities']->addChild('S\'inscrire', array('route' => 'fos_user_registration_register'));       
             }
        return $menu;
    }

//}
//use Knp\Menu\FactoryInterface;
//use Symfony\Component\DependencyInjection\ContainerAware; 
//class MenuBuilder extends ContainerAware { 
//    public function buildMainMenu(FactoryInterface $factory, array $options) {
//        $menu = $factory->createItem('root');
//        $menu->setChildrenAttribute('class', 'nav navbar-nav no-borders');
// 
//        $menu->addChild('entities', array(
//                    'label' => 'Gestion'
//                ))
//                ->setAttribute('dropdown', true)
//                ->setAttribute('icon', 'fa fa-list');
// 
//        $menu['entities']
//                ->addChild('users', array(
//                    'route' => 'admin_users',
//                    'label' => 'Utilisateurs'));
// 
//        $menu['entities']
//                ->addChild('groups', array(
//                    'route' => 'admin_groups',
//                    'label' => 'Groupes'));
// 
//        return $menu;
//    }
// 
//    public function buildUserMenu(FactoryInterface $factory, array $options) {
//        $menu = $factory->createItem('root');
//        $menu->setChildrenAttribute('class', 'nav navbar-nav no-borders navbar-right');
// 
//        $context = $this->container->get('security.context');
//        if ($context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
// 
//            $menu->addChild('profile', array(
//                        'label' => $context->getToken()->getUser()->getUsername()))
//                    ->setAttribute('dropdown', true)
//                    ->setAttribute('icon', 'fa fa-user');
// 
//            $menu['profile']->addChild('Se déconnecter', array('route' => 'fos_user_security_logout'))
//                    ->setAttribute('icon', 'fa fa-unlink');
//            $menu['profile']->addChild("Se connecter sous un autre profil", array('route' => 'fos_user_security_login'))
//                    ->setAttribute('icon', 'fa fa-link');
//        }
// 
//        return $menu;
//    }
}

<?php

namespace boxiweb\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use boxiweb\UserBundle\Entity\user;
use boxiweb\UserBundle\Form\Type\userType;
use boxiweb\UserBundle\Form\Type\userFilterType;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * user controller.
 *
 * @Route("/admin/users")
 */
class userController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="admin_users")
     * @Method("GET")
     * @Template()
     */
   public function indexAction()
    {
       
       
       
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new userFilterType());
        if (!is_null($response = $this->saveFilter($form, 'user', 'admin_users'))) {
            return $response;
        }
        $qb = $em->getRepository('boxiwebUserBundle:user')->createQueryBuilder('u');
//        var_dump($qb);
//        echo "reerre";
        $paginator = $this->filter($form, $qb, 'user');
        
        $entitiesLength = $em->getRepository('boxiwebUserBundle:user')->counter();
        
        return array(
            'form'      => $form->createView(),
            'paginator' => $paginator,
            'entitiesLength'=>$entitiesLength
        );
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}/show", name="admin_users_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(user $user)
    {
        $deleteForm = $this->createDeleteForm($user->getId(), 'admin_users_delete');

        return array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new user entity.
     *
     * @Route("/new", name="admin_users_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $user = new user();
        $form = $this->createForm(new userType(), $user);

        return array(
            'user' => $user,
            'form'   => $form->createView(),
        );
        
         
    }

    /**
 * Creates a new User entity.
 *
 * @Route("/create", name="admin_users_create")
 * @Method("POST")* 
 
 */
public function createAction(Request $request)
{
    $user = new User();
    $form = $this->createForm(new userType(), $user);
    $role = array($form->get('groups')->getData());
//   var_dump($role);   
                        
    if ($form->handleRequest($request)->isValid()) {
$roles = array();
foreach ($role as $key => $value) {
    $roles[] = $key;

    foreach ($value as $value2) {
        $roles[] = $value2;
    }
}
$roles = array_unique($roles);
var_dump($roles);

            $user->setEnabled(true);
        $userManager = $this->get('fos_user.user_manager');
        $userManager->updateUser($user);
 
//        return $this->redirect($this->generateUrl('admin_users_show', array('id' => $user->getId())));
    }
    
   return $this->render('boxiwebUserBundle:user:new.html.twig', array(
                   'user' => $user,
        'form'   => $form->createView(),
        ));
   
}

   // AppBundle\Controller\UserController.php
    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="admin_users_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    /**
 * Displays a form to edit an existing User entity.
 *
 * @Route("/{id}/edit", name="admin_users_edit", requirements={"id"="\d+"})
 * @Method("GET")
 * @Template()
 */
public function editAction(User $user)
{   
 $em = $this->getDoctrine()->getManager();
  $monrole= $em->getRepository('boxiwebUserBundle:Group')->findByRoles($user->getId());
   $monuser= $em->find('boxiwebUserBundle:user', $user);
   
//   $user = new Acme\UserBundle\Entity\User();
//   $encoder = $this->container->get('security.password_encoder');
//   $password = $encoder->encodePassword($user, $plainTextPassword);
   
   
   
    $editForm = $this->createForm(new userType(), $monuser, array(
        'action' => $this->generateUrl('admin_users_update', array(
            'id' => $user->getId())),  
        'method' => 'PUT',
        'passwordRequired' => false,
        'lockedRequired' => true,        
    ));
    $deleteForm = $this->createDeleteForm($user->getId(), 'admin_users_delete');
   return $this->render('boxiwebUserBundle:user:edit.html.twig', array(
                'user' => $user,
        'edit_form'   => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}
 
//
// public function editAction($id = null) {
//        $message = '';
//        $em = $this->get('doctrine')->getEntityManager();
//
//        if (isset($id)) {
//            // modification d'un acteur existant : on recherche ses données
////            $acteur = $em->find('MyAppFilmothequeBundle:Acteur', $id);
//            $monuser= $em->find('boxiwebUserBundle:user', $id);
//            if (!$monuser) {
//                $monuser = 'Aucun acteur trouvé';
//            }
//        } else {
//            // ajout d'un nouvel acteur
//            $monuser = new user();
//        }
//
//        $form = $this->get('form.factory')->create(new userType(), $monuser);
//
//        $request = $this->get('request');
//
//        if ($request->getMethod() == 'POST') {
//            $form->bind($request);
//
//            if ($form->isValid()) {
//                $em->persist($monuser);
//                $em->flush();
//                if (isset($id)) {
//                    $message = 'Acteur modifié avec succès !';
//                } else {
//                    $message = 'Acteur ajouté avec succès !';
//                }
//            }
//        }
//        return $this->render(
//                        'boxiwebUserBundle:user:edit.html.twig', array(
//                    'form' => $form->createView(),
//                    'message' => $message,
//        ));
//    }
//




/**
 * Edits an existing User entity.
 *
 * @Route("/{id}/update", name="admin_users_update", requirements={"id"="\d+"})
 * @Method("PUT")
 * @Template("boxiwebUserBundle:user:edit.html.twig")
 */
public function updateAction(User $user, Request $request)
{
    

    $editForm = $this->createForm(new userType(), $user, array(
        'action' => $this->generateUrl('admin_users_update', array('id' => $user->getId())),
        'method' => 'PUT',
        'passwordRequired' => false,
        'lockedRequired' => true,
        
    ));
    if ($editForm->handleRequest($request)->isValid()) {
        $userManager = $this->get('fos_user.user_manager');
        
        
        $userManager->updateUser($user);
      
        
         
        return $this->redirect($this->generateUrl('admin_users_edit', array('id' => $user->getId())));
    }
    $deleteForm = $this->createDeleteForm($user->getId(), 'admin_users_delete');
 
    return array(
        'user' => $user,
        'edit_form'   => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
    );
}


    /**
     * Save order.
     *
     * @Route("/order/{field}/{type}", name="admin_users_sort")
     */
    public function sortAction($field, $type)
    {
        $this->setOrder('user', $field, $type);

        return $this->redirect($this->generateUrl('admin_users'));
    }

    /**
     * @param string $name  session name
     * @param string $field field name
     * @param string $type  sort type ("ASC"/"DESC")
     */
    protected function setOrder($name, $field, $type = 'ASC')
    {
        $this->getRequest()->getSession()->set('sort.' . $name, array('field' => $field, 'type' => $type));
    }

    /**
     * @param  string $name
     * @return array
     */
    protected function getOrder($name)
    {
        $session = $this->getRequest()->getSession();

        return $session->has('sort.' . $name) ? $session->get('sort.' . $name) : null;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $name
     */
    protected function addQueryBuilderSort(QueryBuilder $qb, $name)
    {
        $alias = current($qb->getDQLPart('from'))->getAlias();
        if (is_array($order = $this->getOrder($name))) {
            $qb->orderBy($alias . '.' . $order['field'], $order['type']);
        }
    }

    /**
     * Save filters
     *
     * @param  FormInterface $form
     * @param  string        $name   route/entity name
     * @param  string        $route  route name, if different from entity name
     * @param  array         $params possible route parameters
     * @return Response
     */
    protected function saveFilter(FormInterface $form, $name, $route = null, array $params = null)
    {
        $request = $this->getRequest();
        $url = $this->generateUrl($route ?: $name, is_null($params) ? array() : $params);
        if ($request->query->has('submit-filter') && $form->handleRequest($request)->isValid()) {
            $request->getSession()->set('filter.' . $name, $request->query->get($form->getName()));

            return $this->redirect($url);
        } elseif ($request->query->has('reset-filter')) {
            $request->getSession()->set('filter.' . $name, null);

            return $this->redirect($url);
        }
    }

    /**
     * Filter form
     *
     * @param  FormInterface                                       $form
     * @param  QueryBuilder                                        $qb
     * @param  string                                              $name
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    protected function filter(FormInterface $form, QueryBuilder $qb, $name)
    {
        if (!is_null($values = $this->getFilter($name))) {
            if ($form->submit($values)->isValid()) {
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $qb);
            }
        }

        // possible sorting
        $this->addQueryBuilderSort($qb, $name);
        return $this->get('knp_paginator')->paginate($qb, $this->getRequest()->query->get('page', 1), 20);
    }

    /**
     * Get filters from session
     *
     * @param  string $name
     * @return array
     */
    protected function getFilter($name)
    {
        return $this->getRequest()->getSession()->get('filter.' . $name);
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}/delete", name="admin_users_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(user $user, Request $request)
    {
        $form = $this->createDeleteForm($user->getId(), 'admin_users_delete');
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_users'));
    }

    /**
     * Create Delete form
     *
     * @param integer                       $id
     * @param string                        $route
     * @return \Symfony\Component\Form\Form
     */
    protected function createDeleteForm($id, $route)
    {
        return $this->createFormBuilder(null, array('attr' => array('id' => 'delete')))
            ->setAction($this->generateUrl($route, array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}

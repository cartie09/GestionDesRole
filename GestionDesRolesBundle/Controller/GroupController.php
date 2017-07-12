<?php

namespace boxiweb\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use boxiweb\UserBundle\Entity\Group;
use boxiweb\UserBundle\Form\Type\GroupType;
use boxiweb\UserBundle\Form\Type\GroupFilterType;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * Group controller.
 *
 * @Route("/admin/groups")
 */
class GroupController extends Controller
{
    /**
     * Lists all Group entities.
     *
     * @Route("/", name="admin_groups")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
         
        
        
        
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
    throw $this->createAccessDeniedException();
}
 
//$user = $this->getUser();
// 
//var_dump($user->getEmail());
        
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new GroupFilterType());
        if (!is_null($response = $this->saveFilter($form, 'group', 'admin_groups'))) {
            return $response;
        }
        $qb = $em->getRepository('boxiwebUserBundle:Group')->createQueryBuilder('g');
        $paginator = $this->filter($form, $qb, 'group');
//        var_dump($qb);
        return array(
            'form'      => $form->createView(),
            'paginator' => $paginator,
        );
    }

    /**
     * Finds and displays a Group entity.
     *
     * @Route("/{id}/show", name="admin_groups_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction(Group $group)
    {
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_groups_delete');

        return array(
            'group' => $group,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Group entity.
     *
     * @Route("/new", name="admin_groups_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $group = new Group();
        $form = $this->createForm(new GroupType(), $group);

        return array(
            'group' => $group,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Group entity.
     *
     * @Route("/create", name="admin_groups_create")
     * @Method("POST")
     * @Template("boxiwebUserBundle:group:new.html.twig")
     */
    public function createAction(Request $request)
    {  $em = $this->get('doctrine')->getEntityManager();
        $group = new Group();
        $form = $this->createForm(new GroupType(), $group);
// $group->setRoles(array('roles' => 'ROLE_ADMIN'));
//        var_dump($form->getData())  ;
//        $username = $form["roles"]->getData();
//        var_dump($username);
        
      
        
        
        if ($form->handleRequest($request)->isValid()) {
         $personnel = $form->getData();
            $roles = $form->get('roles')->getData();
            $personnel->setRoles($roles);
            var_dump($personnel);
         
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

           return $this->redirect($this->generateUrl('admin_groups_show', array('id' => $group->getId())));
        }


     return $this->render('boxiwebUserBundle:group:new.html.twig', array(
                  'group' => $group,
            'form'   => $form->createView(),
         ));
        
        
        
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @Route("/{id}/edit", name="admin_groups_edit", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function editAction(Group $group)
    {
        $editForm = $this->createForm(new GroupType(), $group, array(
            'action' => $this->generateUrl('admin_groups_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_groups_delete');

        return array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Group entity.
     *
     * @Route("/{id}/update", name="admin_groups_update", requirements={"id"="\d+"})
     * @Method("PUT")
     * @Template("boxiwebUserBundle:Group:edit.html.twig")
     */
    public function updateAction(Group $group, Request $request)
    {
        $editForm = $this->createForm(new GroupType(), $group, array(
            'action' => $this->generateUrl('admin_groups_update', array('id' => $group->getId())),
            'method' => 'PUT',
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('admin_groups_edit', array('id' => $group->getId())));
        }
        $deleteForm = $this->createDeleteForm($group->getId(), 'admin_groups_delete');

        return array(
            'group' => $group,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

 
    /**
     * Save order.
     *
     * @Route("/order/{field}/{type}", name="admin_groups_sort")
     */
    public function sortAction($field, $type)
    {
        $this->setOrder('group', $field, $type);

        return $this->redirect($this->generateUrl('admin_groups'));
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
     * Deletes a User entity.
     *
    
     * @Route("/{id}/delete", name="admin_users_delete", requirements={"id"="\d+"})
     * @Method("DELETE")
     */
    public function deleteAction(Group $group, Request $request)
    {
        if (!$this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
//      $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Vous ne possédez pas les droits suffisants pour accéder à la page!');
//
//        throw new NotFoundHttpException('Accès limité aux ROLE_SUPER_ADMIN.');
//            $this->get('session')->getFlashBag()->add('error', "Il y a des erreurs dans le formulaire soumis !");
    
//                throw new NotFoundHttpException(sprintf('The group with "%s" does not exist "', $group));
//        $this->get('session')->getFlashBag()->add('success', "Il y a des erreurs dans le formulaire soumis !");
//$request->getSession()
//        ->getFlashBag()
//        ->add('success', 'Welcome to the Death Star, have a magical day!')
//    ;

//         return new Response(
//            '<html><body>Lucky number: '.$number.'</body></html>'
//        );
//          return $this->redirectToRoute('admin_groups');
//             return new Response(
//            'fdsfsdfsff'
//        );
        }
//        $this->get('session')->getFlashBag()->add(
//        'notice',
//        'Customer Added!'
//    );
        $form = $this->createDeleteForm($group->getId(), 'admin_groups_delete');

 
        
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($group);
            $em->flush();
                  // Flash de réussite
   
        }
//        $this->setFlash('fos_user_success', 'le groupe a été supprimé avec succeés');
//$this->get('session')->getFlashBag()->add('success', "Supression effectué avec succée.");
       return $this->redirect($this->generateUrl('admin_groups'));
        
        
//          return $this->render('boxiwebUserBundle:group:edit.html.twig', array(
//                  'msg' => $request,
//           
//         ));
//        
         
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
 /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->get('session')->getFlashBag()->set($action, $value);
    }
    
    
}

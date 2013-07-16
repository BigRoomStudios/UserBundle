<?php

namespace BRS\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

use FOS\UserBundle\Controller\RegistrationController as BaseController;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

use Symfony\Component\EventDispatcher\EventDispatcher,
    Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
    Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 *
 */
class RegistrationController extends BaseController
{
	
	/**
	 * 
	 */
	public function registerAction(Request $request) {
		
		$params = $_POST ? $_POST : $_GET;
		
		$_POST['fos_user_registration_form']['username'] = $_POST['fos_user_registration_form']['email'];
		
		$formFactory = $this->container->get('fos_user.registration.form.factory');
		$userManager = $this->container->get('fos_user.user_manager');
		$dispatcher = $this->container->get('event_dispatcher');
		
		$user = $userManager->createUser();
		$user->setEnabled(true);
		
		$dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, new UserEvent($user, $request));
		
		$form = $formFactory->createForm();
		$form->setData($user);
		
		if ('POST' === $request->getMethod()) {
		    $form->bind($request);
			
		    if ($form->isValid()) {
		    	
				//generate an error message
				// $response = array(
					// 'success' => false,
					// 'message' => ,
				// );
				// $response = new Response(json_encode($response));
				// $response->headers->set('Content-Type', 'application/json');
				// return $response;
				
		        $event = new FormEvent($form, $request);
		        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
				
				//this is the default...so I don't know if its needed
				//$user->addRole(static::ROLE_USER);
				
		        $userManager->updateUser($user);
				
		        //if (null === $response = $event->getResponse()) {
		        //    $url = $this->container->get('router')->generate('fos_user_registration_confirmed');
		        //    $response = new RedirectResponse($url);
		        //}
				
				$url = ($this->container->get('kernel')->getEnvironment() == 'dev' ? 'dev.php/' : '') . 'dashboard';
				
				//redirect the user to the dashboard
				$response = array(
					'success' => true,
					'redirect' => "/$url",
				);
				
		        //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
				
				$token = new UsernamePasswordToken($user, $user->getPassword(),
                                       "public", $user->getRoles());

			    $this->container->get("security.context")->setToken($token);
			
			    // Trigger login event
			    $event = new InteractiveLoginEvent($request, $token);
			    $this->container->get("event_dispatcher")
			         ->dispatch("security.interactive_login", $event);
				
		        $response = new Response(json_encode($response));
				$response->headers->set('Content-Type', 'application/json');
				
				return $response;
				
		    }
			else {
				
				$data = $form->getData();
				
				//generate an error message
				$response = array(
					'success' => false,
					'message' => $form->getErrorsAsString() . "\n" . print_r($_POST, true),
				);
				$response = new Response(json_encode($response));
				$response->headers->set('Content-Type', 'application/json');
				return $response;
				
			}
			
		}
		
		//generate an error message
		$response = array(
			'success' => false,
			'message' => 'past post',
		);
		$response = new Response(json_encode($response));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
		
		return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
		    'form' => $form->createView(),
		));
		
		/*
		//generate an error message
		$response = array(
			'success' => false,
			'message' => print_r($params, true),
		);
		$response = new Response(json_encode($response));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
		*/
		
	}
	
}

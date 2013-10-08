<?php

namespace BRS\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

//use FOS\UserBundle\Controller\RegistrationController as BaseController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

use Doctrine\DBAL\DBALException;

/**
 * 
 */
class RegistrationController extends Controller
{
	
	/**
	 * 
	 */
	public function ajaxRegisterAction(Request $request) {
		
		//initialize some shit!
		$formFactory = $this->container->get('fos_user.registration.form.factory');
		$userManager = $this->container->get('fos_user.user_manager');
		$user = $userManager->createUser();
		$user->setEnabled(true);
		$form = $formFactory->createForm();
		$form->setData($user);
		
		//if the form method is post
		if ('POST' === $request->getMethod()) {
			
			//bind the request
		    $form->bind($request);
			
			//if the form is valid
		    if($form->isValid()) {
		    	
				//save the user
				$userManager->updateUser($user);
				
				//log the new user in
				$token = new UsernamePasswordToken($user, $user->getPassword(), "public", $user->getRoles());
				$this->container->get("security.context")->setToken($token);
				
				// Trigger login event
				$event = new InteractiveLoginEvent($request, $token);
				$this->container->get("event_dispatcher")->dispatch("security.interactive_login", $event);
				
				//get the form data
				$form_data = $form->getData();
				$first_name = $form_data->getFirstName();
				
				//send the registration email
				$message = \Swift_Message::newInstance()
					->setSubject("Welcome to Hazel, $first_name")
					->setFrom('no-reply@bigroomstudios.com')
					->setTo($form_data->getEmail())
					->setBody("Example Text");
				
				$this->get('mailer')->send($message);
				
				//$route = $this->get('router')->generate('property_claim');
				
				//redirect the user to the dashboard
				$response = array(
					'success' => true,
					'redirect' => $route,
				);
				
				$response = new Response(json_encode($response));
				$response->headers->set('Content-Type', 'application/json');
				
				return $response;
				
		    }
			else {
				
				$errors = $form->getErrors();
				
				$error_template = $errors[0]->getMessageTemplate();
				
				if($error_template == 'fos_user.username.already_used') {
					$message = 'User already exists';
				}
				else {
					$message = 'Unknown error occurred';
				}
				
				//generate an error message
				$response = array(
					'success' => false,
					'message' => $message,
				);
				$response = new Response(json_encode($response));
				$response->headers->set('Content-Type', 'application/json');
				return $response;
				
			}
			
		}
		
		//something else should happen here.  They are supposed to access this via a post request...I think a refactoring of this controller will take care of it...so leaving it for now
		$response = array(
			'success' => false,
			'message' => 'Incorrect method',
		);
		
		$response = new Response(json_encode($response));
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
		
	}
	
	/**
	 * 
	 
	public function registerAction(Request $request) {
		
		//initialize some shit!
		$formFactory = $this->container->get('fos_user.registration.form.factory');
		$userManager = $this->container->get('fos_user.user_manager');
		$user = $userManager->createUser();
		$user->setEnabled(true);
		$form = $formFactory->createForm();
		$form->setData($user);
		
		//if the form method is post
		if ('POST' === $request->getMethod()) {
			
			//bind the request
		    $form->bind($request);
			
			//if the form is valid
		    if($form->isValid()) {
		    	
				//save the user
				$userManager->updateUser($user);
				
				//log the new user in
				$token = new UsernamePasswordToken($user, $user->getPassword(), "public", $user->getRoles());
				$this->container->get("security.context")->setToken($token);
				
				// Trigger login event
				$event = new InteractiveLoginEvent($request, $token);
				$this->container->get("event_dispatcher")->dispatch("security.interactive_login", $event);
				
				//get the form data
				$form_data = $form->getData();
				$first_name = $form_data->getFirstName();
				
				//send the registration email
				$message = \Swift_Message::newInstance()
					->setSubject("Welcome to Hazel, $first_name")
					->setFrom('no-reply@bigroomstudios.com')
					->setTo($form_data->getEmail())
					->setBody("Example Text");
				
				$this->get('mailer')->send($message);
				
				//$route = $this->get('router')->generate('property_claim');
				
				//redirect the user to the dashboard
				$response = array(
					'success' => true,
					'redirect' => $route,
				);
				
				$response = new Response(json_encode($response));
				$response->headers->set('Content-Type', 'application/json');
				
				return $response;
				
		    }
			else {
				
				$errors = $form->getErrors();
				
				$error_template = $errors[0]->getMessageTemplate();
				
				if($error_template == 'fos_user.username.already_used') {
					$message = 'User already exists';
				}
				else {
					$message = 'Unknown error occurred';
				}
				
				//generate an error message
				$response = array(
					'success' => false,
					'message' => $message,
				);
				$response = new Response(json_encode($response));
				$response->headers->set('Content-Type', 'application/json');
				return $response;
				
			}
			
		}
		
		//something else should happen here.  They are supposed to access this via a post request...I think a refactoring of this controller will take care of it...so leaving it for now
		$response = array(
			'success' => false,
			'message' => 'Incorrect method',
		);
		
		$response = new Response(json_encode($response));
		$response->headers->set('Content-Type', 'application/json');
		
		return $response;
		
	}*/
	
}

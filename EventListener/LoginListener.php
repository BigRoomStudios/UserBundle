<?php
 
namespace BRS\UserBundle\EventListener;
 
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginListener
{
	
	private $router;
	
	public function __construct(UrlGeneratorInterface $router) {
		$this->router = $router;
	}
	
	/**
	 * forces a redirect to the edit a property page when a user logs in...kind of a hack for now
	 */
	public function onLogin(InteractiveLoginEvent $event) {
		
		$request = $event->getRequest();
		
		$route = $this->router->generate('hazel_property_edit');
		$route = str_replace('dev.php/', '', $route);
		
		$request->request->set('_target_path', $route);
		
	}
}
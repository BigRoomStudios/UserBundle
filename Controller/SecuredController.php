<?php

namespace BRS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecuredController extends Controller
{
	
	public function indexAction() {
		//this page requires the user to be logged in
		return $this->render('BRSUserBundle:Secured:index.html.twig');
	}
	
}
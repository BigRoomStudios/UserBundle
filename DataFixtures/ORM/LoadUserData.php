<?php

namespace BRS\PageBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use BRS\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture
{
	
	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager) {
		
		//create a test content
		$user = new User();
		$user->setEmail('test@bigroomstudios.com');
		$user->setPlainPassword('password');
		$user->addRole('ROLE_ADMIN');
		$user->setEnabled(true);
		
		//save the root page
		$manager->persist($user);
		$manager->flush();
		
	}
	
}
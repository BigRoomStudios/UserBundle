<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BRS\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseUser;

class RegistrationFormType extends BaseUser
{
	private $class;
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
			//->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
			->add('plainPassword', 'repeated', array(
				'type' => 'password',
				'options' => array('translation_domain' => 'FOSUserBundle'),
				'first_options' => array('label' => 'form.password'),
				'second_options' => array('label' => 'form.password_confirmation'),
				'invalid_message' => 'fos_user.password.mismatch',
			))
		;
    }

}

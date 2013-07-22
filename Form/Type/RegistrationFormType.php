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
        	->add(
            	'first_name',
            	null, 
            	array(
            		'label' => 'First Name',
            		'attr' => array(
            			'icon' => 'icon-user',
            			'class' => 'form_input_text valid-empty',
            			'placeholder' => 'First Name',
            		),
				))
			->add(
				'last_name',
				null,
				array(
					'label' => 'Last Name',
					'attr' => array(
            			'icon' => 'icon-user',
            			'class' => 'form_input_text valid-empty',
            			'placeholder' => 'Last Name',
            		),
				))
            ->add(
            	'email',
            	'email',
            	array(
            		'label' => 'Email',
            		'attr' => array(
            			'icon' => 'icon-email',
            			'class' => 'form_input_text valid-email',
            			'placeholder' => 'Email Address',
            		),
				))
            ->add(
            	'plainPassword',
            	'password',
            	array(
            		'label' => 'Password',
            		'attr' => array(
            			'icon' => 'icon-key',
            			'class' => 'form_input_password valid-empty',
            			'placeholder' => 'Type your super secret password here',
            		),
				))
			->add(
            	'security_question',
            	'choice',
            	array(
            		'label' => 'Security Question',
            		'choices' => array(
            			'star_wars' => 'Who is your favorite Star Wars character?',
            			'ice_cream' => 'What is your favorite ice cream flavor?',
            			'fav_color' => 'What is your favorite color?',
					),
            		'attr' => array(
            			'class' => 'form_input_password valid-empty',
            			'placeholder' => 'Type your super secret password here',
            		),
				))
			->add(
            	'security_answer',
            	'text',
            	array(
            		'label' => 'Security Answer',
            		'attr' => array(
            			'icon' => 'icon-key',
            			'class' => 'form_input_password valid-empty',
            			'placeholder' => 'Type your answer here',
            		),
				))
			;
    }
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		
		$resolver->setDefaults(array(
			'data_class' => $this->class,
			'intention'  => 'registration',
			'validation_groups' => array('BRS_Registration'),
		));
		
	}
	
	public function getName() {
		
		return 'brs_user_registration';
		
	}
	
}

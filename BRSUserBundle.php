<?php

namespace BRS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BRSUserBundle extends Bundle
{
	
	public function getParent() {
		
		return 'FOSUserBundle';
		
	}
	
}

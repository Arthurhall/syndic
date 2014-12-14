<?php

namespace Syndic\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SyndicUserBundle extends Bundle
{
	public function getParent()
    {
        return 'SonataUserBundle';
    }
}

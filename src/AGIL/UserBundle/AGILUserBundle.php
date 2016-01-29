<?php

namespace AGIL\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AGILUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

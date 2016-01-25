<?php

namespace AGIL\DefaultBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AGILDefaultBundle extends Bundle
{

    public function getParent(){
        return 'FOSUserBundle';
    }


}

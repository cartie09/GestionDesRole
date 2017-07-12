<?php

namespace boxiweb\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class boxiwebUserBundle extends Bundle
{
    public function getParent() {
        return "FOSUserBundle"; 
    }
}

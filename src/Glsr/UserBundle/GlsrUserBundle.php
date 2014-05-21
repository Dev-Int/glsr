<?php

namespace Glsr\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GlsrUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

<?php
// src\Sdz\BlogBundle\Validator\AntiFloodValidator.php

namespace Sdz\BlogBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class AntiFloodValidator extends ConstraintValidator {
    private $request;
    private $em;
    
    function __construct(Request $request, EntityManager $em)
    {
        $this->request = $request;
        $this->em      = $em;
    }
            
    function validate($value, Constraint $constraint)
    {
        // On récupère l'IP de celui qui poste
        $ip = $this->request->server->get('REMOTE_ADDR');
        
        // On vérifie si cette IP a déjà posté un message il y a moins de 15 secondes
        $isFlood = $this->em->getRepository('SdzBlogBundle: Article')
                ->isFlood($ip, 15
                        );
        if (strlen($value) < 3 && $isFlood) {
            $this->context->addViolation($constraint->message);
        }
    }

}
?>

<?php
// src\Glsr\UserBundle\DataFixtures\ORM\Users.php

namespace Glsr\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Glsr\UserBundle\Entity\User;

class Users implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Maintenant que nous avons FOSUB, on désactive cette fixture
        // Supprimez ce if si vous en avez toujours besoin
        if (true) {
            return;
        }

        // Les noms d'utilisateurs à créer
        $noms = array('winzou', 'John', 'Talus');
        
        foreach ($noms as $i => $nom) {
            // On crée l'uilisateur
            $users[$i] = new User;
            
            // Le nom d'utilisateur et le mot de pass sont identiques
            $users[$i]->setUsername($nom);
            $users[$i]->setPassword($nom);
            
            // Le sel et les rôles sont vides pour l'instant
            $users[$i]->setSalt('');
            $users[$i]->setRoles(array());
            
            // On persiste
            $manager->persist($users[$i]);
        }
        
        // On déclenche l'enregistrement
        $manager->flush();
    }
}

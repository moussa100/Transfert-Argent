<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST', 'DELET'])
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        //dd($user);
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        if ($user->getProfil()[0] === 'ROLE_ADMIN_SYSTEM')
        {
            return true;
        }
        if ($user->getProfil()[0] === 'ROLE_CAISSIER'|| $user->getProfil()[0] === 'ROLE_PARTENAIRE')
        {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'POST':
                return $user->getProfil()[0] === 'ROLE_ADMIN' &&
                ($subject->getProfil()[0] === 'ROLE_CAISSIER' || 
                 $subject->getProfil()[0] === 'ROLE_PARTENAIRE');
                break;
            case 'POST_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}

<?php

namespace App\Security\Voter;

use App\Entity\Portfolio;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class PortfolioVoter extends Voter
{
    public const EDIT = 'edit';
    public const VIEW = 'view';
    public const DELETE = 'delete';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Portfolio) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $portfolio = $subject;
        // ... (check conditions and return true to grant permission) ...
       return  match ($attribute) {
           self::VIEW => $this->canView($portfolio, $user),
           self::EDIT => $this->canEdit($portfolio, $user),
           self::DELETE => $this->canDelete($portfolio, $user),
           default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(Portfolio $portfolio, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($portfolio, $user)) {
            return true;
        };
        return false;
    }

    private function canEdit(Portfolio $portfolio, User $user): bool
    {
        return $user === $portfolio->getUser();
    }

    private function canDelete(Portfolio $portfolio, User $user): bool
    {
        if ($this->canEdit($portfolio, $user)) {
            return true;
        }
        return false;
    }
}

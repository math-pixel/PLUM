<?php

namespace App\Security\Voter;

use App\Entity\Asset;
use App\Entity\Portfolio;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class AssetVoter extends Voter
{
    public const EDIT = 'edit';
    public const VIEW = 'view';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Asset;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $asset = $subject;
        // ... (check conditions and return true to grant permission) ...
        return match ($attribute) {
            self::VIEW => $this->canView($asset, $user),
            self::EDIT => $this->canEdit($asset, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(Asset $asset, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($asset, $user)) {
            return true;
        };
        return false;
    }

    private function canEdit(Asset $asset, User $user): bool
    {
        return $user === $asset->getUser();
    }

    private function canDelete(Asset $asset, User $user): bool
    {
        if ($this->canEdit($asset, $user)) {
            return true;
        }
        return false;
    }
}
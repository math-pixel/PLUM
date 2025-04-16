<?php

namespace App\Security\Voter;

use App\Entity\Portfolio;
use App\Entity\Transaction;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class TransactionVoter extends Voter
{
    public const EDIT = 'edit';

    public const DELETE = 'delete';
    public const CREATE = 'create';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Transaction;
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
            self::EDIT => $this->canEdit($portfolio, $user),
            self::DELETE => $this->canDelete($portfolio, $user),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canView(Transaction $transaction, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($transaction, $user)) {
            return true;
        };
        return false;
    }

    private function canEdit(Transaction $transaction, User $user): bool
    {
        return $user === $transaction->getUser();
    }

    private function canDelete(Transaction $transaction, User $user): bool
    {
        if ($this->canEdit($transaction, $user)) {
            return true;
        }
        return false;
    }

}

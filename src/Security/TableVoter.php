<?php

namespace App\Security;

use App\Entity\Table;
use App\Entity\User;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TableVoter extends Voter
{
    const MASTER = 'master';
    const PLAYER = 'player';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::MASTER, self::PLAYER])) {
            return false;
        }
        if (!$subject instanceof Table) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /**
         * @var Table $table
         */
        $table = $subject;

        return match($attribute) {
            self::MASTER => $this->isMaster($table, $user),
            self::PLAYER => $this->isPlayer($table, $user),
            default => throw new LogicException('Wrong attribute given to Voter')
        };
    }

    private function isMaster(Table $table, User $user): bool
    {
        return $user === $table->getMaster();
    }

    private function isPlayer(Table $table, User $user): bool
    {
        return $table->getPlayers()->contains($user);
    }
}
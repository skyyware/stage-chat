<?php

declare(strict_types=1);

namespace Stage\Chat;

use RuntimeException;

final class Failure extends RuntimeException
{
    public function __construct(public readonly FailureReason $reason)
    {
        parent::__construct(match ($reason) {
            FailureReason::Unavailable => 'Chat provider is unavailable.',
            FailureReason::Timeout => 'Chat provider timed out.',
            FailureReason::Cancelled => 'Chat request was cancelled.',
            FailureReason::InvalidResponse => 'Chat provider returned an invalid response.',
        });
    }
}

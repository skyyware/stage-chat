<?php

declare(strict_types=1);

namespace Stage\Chat;

enum FailureReason: string
{
    case Unavailable = 'unavailable';
    case Timeout = 'timeout';
    case Cancelled = 'cancelled';
    case InvalidResponse = 'invalid_response';
}

<?php

declare(strict_types=1);

namespace Stage\Chat;

enum Role: string
{
    case User = 'user';
    case Assistant = 'assistant';
}

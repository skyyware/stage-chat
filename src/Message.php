<?php

declare(strict_types=1);

namespace Stage\Chat;

use InvalidArgumentException;
use SensitiveParameter;

final readonly class Message
{
    public const int MAX_BYTES = 16384;

    public function __construct(public Role $role, #[SensitiveParameter] public string $content)
    {
        if (trim($content) === '' || strlen($content) > self::MAX_BYTES || preg_match('//u', $content) !== 1) {
            throw new InvalidArgumentException('Message must contain valid UTF-8 text within the size limit.');
        }
    }
}

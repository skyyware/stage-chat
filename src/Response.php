<?php

declare(strict_types=1);

namespace Stage\Chat;

use InvalidArgumentException;
use SensitiveParameter;

final readonly class Response
{
    public function __construct(#[SensitiveParameter] public string $text)
    {
        if (trim($text) === '' || preg_match('//u', $text) !== 1) {
            throw new InvalidArgumentException('Response must contain valid UTF-8 text.');
        }
    }
}

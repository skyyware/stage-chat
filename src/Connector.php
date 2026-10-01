<?php

declare(strict_types=1);

namespace Stage\Chat;

use Closure;
use SensitiveParameter;

interface Connector
{
    /** @param (Closure(): bool)|null $cancelled */
    public function complete(#[SensitiveParameter] Request $request, ?Closure $cancelled = null): Response;
}

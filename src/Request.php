<?php

declare(strict_types=1);

namespace Stage\Chat;

use InvalidArgumentException;
use SensitiveParameter;

final readonly class Request
{
    public const int MAX_BYTES = 131072;
    public const int MAX_MESSAGES = 40;
    public const int MAX_INSTRUCTION_BYTES = 16384;

    /** @var list<Message> */
    public array $messages;

    /** @param array<array-key, Message> $messages */
    public function __construct(
        #[SensitiveParameter] public string $instructions,
        #[SensitiveParameter] public string $context,
        #[SensitiveParameter] array $messages,
    ) {
        if (trim($instructions) === '' || strlen($instructions) > self::MAX_INSTRUCTION_BYTES) {
            throw new InvalidArgumentException('Application instructions must be present and within the size limit.');
        }

        if (!array_is_list($messages) || $messages === [] || count($messages) > self::MAX_MESSAGES) {
            throw new InvalidArgumentException('Conversation must be a nonempty list within the message limit.');
        }

        $bytes = strlen($instructions) + strlen($context);
        foreach ($messages as $message) {
            $bytes += strlen($message->content);
        }

        if ($bytes > self::MAX_BYTES || preg_match('//u', $instructions . $context) !== 1) {
            throw new InvalidArgumentException('Request must contain valid UTF-8 text within the size limit.');
        }

        if ($messages[array_key_last($messages)]->role !== Role::User) {
            throw new InvalidArgumentException('Conversation must end with a user message.');
        }

        $this->messages = $messages;
    }
}

<?php

declare(strict_types=1);

namespace Stage\Chat\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Stage\Chat\Failure;
use Stage\Chat\FailureReason;
use Stage\Chat\Message;
use Stage\Chat\Request;
use Stage\Chat\Response;
use Stage\Chat\Role;

final class ContractTest extends TestCase
{
    public function testConversationKeepsPolicyAndSourceDataSeparate(): void
    {
        $messages = [new Message(Role::User, 'Earlier question'), new Message(Role::Assistant, 'Earlier answer'), new Message(Role::User, 'Current question')];
        $request = new Request('Trusted policy', 'Untrusted source', $messages);

        self::assertSame($messages, $request->messages);
        self::assertSame('Trusted policy', $request->instructions);
        self::assertSame('Untrusted source', $request->context);
        self::assertSame('Final answer', new Response('Final answer')->text);
    }

    #[DataProvider('invalidMessages')]
    public function testInvalidMessageTextIsRejected(string $content): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Message(Role::User, $content);
    }

    /** @return iterable<string, array{string}> */
    public static function invalidMessages(): iterable
    {
        yield 'empty' => [''];
        yield 'whitespace' => [" \n"];
        yield 'oversized' => [str_repeat('x', Message::MAX_BYTES + 1)];
        yield 'invalid UTF-8' => ["\xff"];
    }

    /** @param list<Message> $messages */
    #[DataProvider('invalidRequests')]
    public function testInvalidRequestsAreRejected(string $instructions, string $context, array $messages): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Request($instructions, $context, $messages);
    }

    /** @return iterable<string, array{string, string, list<Message>}> */
    public static function invalidRequests(): iterable
    {
        $message = new Message(Role::User, 'Question');
        yield 'no instructions' => ['', '', [$message]];
        yield 'large instructions' => [str_repeat('x', Request::MAX_INSTRUCTION_BYTES + 1), '', [$message]];
        yield 'no messages' => ['Policy', '', []];
        yield 'too many messages' => ['Policy', '', array_fill(0, Request::MAX_MESSAGES + 1, $message)];
        yield 'too large' => ['Policy', str_repeat('x', Request::MAX_BYTES), [$message]];
        yield 'invalid context' => ['Policy', "\xff", [$message]];
        yield 'assistant last' => ['Policy', '', [new Message(Role::Assistant, 'Answer')]];
    }

    public function testFailureMessagesContainNoProviderPayload(): void
    {
        foreach (FailureReason::cases() as $reason) {
            $failure = new Failure($reason);
            self::assertSame($reason, $failure->reason);
            self::assertNull($failure->getPrevious());
            self::assertNotSame('', $failure->getMessage());
        }
    }
}

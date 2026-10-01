# Stage Chat

A small PHP contract for stateless chat providers. Applications own their
conversation, retrieved context and answer rules. Providers return one final
response. PHP 8.4 or newer. MIT licensed.

```sh
composer require skyyware/stage-chat:^0.1
```

While the repository is private, configure an authenticated Composer VCS
repository for `git@github.com:skyyware/stage-chat.git` and prefer source
installation. No Packagist availability is implied by a Git tag.

```php
use Stage\Chat\Connector;
use Stage\Chat\Message;
use Stage\Chat\Request;
use Stage\Chat\Response;
use Stage\Chat\Role;

function answer(Connector $chat, string $question, string $context): Response
{
    return $chat->complete(new Request(
        instructions: 'Answer using the supplied context. Say when it is insufficient.',
        context: $context,
        messages: [new Message(Role::User, $question)],
    ));
}
```

`instructions` is trusted application policy. Construct it on the server.
`context` and all messages are untrusted data, including browser-supplied
assistant history. Only `user` and `assistant` roles exist. A conversation
must end with a user message. This separation is not a substitute for
authorization or validating a provider's answer.

The contract permits 40 messages, 16 KiB per message, 16 KiB of instructions
and 128 KiB of combined text. Reject oversized HTTP requests before decoding
them; apply smaller product limits before constructing a `Request`.
Trim older messages deliberately when the conversation reaches your limit.

`Connector::complete()` accepts an optional `Closure(): bool` cancellation
check. A provider should poll it while waiting. `Response::$text` contains
the final answer. A connector can request structured JSON; the application
still validates its schema, facts and source links before rendering it.

Catch `Failure` and inspect `$failure->reason`: `Unavailable`, `Timeout`,
`Cancelled` or `InvalidResponse`. These errors carry stable, content-free
messages. Invalid application inputs raise `InvalidArgumentException`.
Do not display exception traces or log request/response objects.

This package contains no storage, session IDs, tools, network client,
retries or background jobs. Tenant selection, retrieval, HTTP authentication,
rate limits, concurrency limits and browser history belong in the application.
Provider processing and retention depend on the selected connector and service.

## Development

```sh
composer install
composer check
```

Tests and static analysis run locally. Changes should keep the public contract
small, test denied and malformed inputs, and explain observable behavior.

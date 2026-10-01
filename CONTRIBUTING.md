# Contribute to Stage Chat

Bug reports, documentation fixes, and focused pull requests are welcome.
Include the package version, PHP version, a synthetic reproduction, the
expected result, and the actual result. Never include conversation records,
credentials, or personal data in an issue or patch.

1. Fork and clone the repository. Read README.md and AGENTS.md.
2. Run `composer install` with PHP 8.4 or later.
3. Keep the contract independent of providers, HTTP, storage, and application policy.
4. Test changed behavior, including malformed input and failure categories.
5. Update the examples and documentation together with the contract.
6. Run `composer check` and open a focused pull request with the problem, resulting behavior, and validation.

PHPStan runs at maximum level. Use explicit PHP types and constructors.
Add no narrative comments or TODOs; type annotations consumed by PHPStan and
required legal notices are allowed. Repository automation is disabled, so
run checks locally. Humans and agents follow the same contribution standards.
Contributions are available under the [MIT license](LICENSE).

Maintainers follow [RELEASING.md](RELEASING.md). Report vulnerabilities through
[private reporting](SECURITY.md) rather than a public issue.

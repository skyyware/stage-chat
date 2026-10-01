# Working on Stage Chat

Read README.md. Keep this package independent of providers, HTTP, storage,
retrieval and application answer formats. Its public contract is intentionally
small. Do not add persistence or application-specific rules.

Run `composer check` after meaningful changes. Exercise invalid inputs and
provider failures as well as successful calls. No explanatory source comments
or TODOs; PHPDoc consumed by static analysis and legal notices are allowed.

Never commit credentials, dependencies, runtime files or conversation data.
Keep repository automation disabled. Public visibility needs maintainer authority.

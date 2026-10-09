# Release Stage Chat

Follow the [Stage package release workflow](https://github.com/skyyware/stage/blob/main/docs/releases.md).
This repository owns `skyyware/stage-chat` and its contract version.

Review package docs, executable examples, and affected stage.dev curated
articles in the same delivery. Follow the shared
[documentation and Starchat knowledge review](https://github.com/skyyware/stage/blob/main/docs/releases.md#review-documentation-and-starchat-knowledge)
for source mappings, installation ownership, and verification.

Run `composer check`, then execute the README request example in a fresh
Composer consumer without authentication or repository overrides. Keep the
provider contract independent of application and vendor configuration.

The current release is 0.1.1. It preserves the 0.1.0 API and limits. Publish
an immutable tag, a GitHub Release, and the matching Packagist version. For
later versions, update the changelog and this version before publication.

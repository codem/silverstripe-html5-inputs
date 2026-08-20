# Devcontainer setup for a Silverstripe vendor module (static analysis + tests only)

Drop the contents of this bundle into the root of your module repo:

```
your-module/
├── .devcontainer/
│   ├── devcontainer.json
│   ├── docker-compose.yml
│   ├── Dockerfile
│   └── post-create.sh
└── composer.json          (already exists in your module)
```

Your existing `phpunit.xml` and `.gitignore` are unchanged. `/vendor/` is
already covered in your `.gitignore`; `/.test-project/` is no longer used by
this setup and can be removed from `.gitignore` whenever you like (harmless
to leave it too).

## What this is for

This devcontainer exists for exactly four things: `phpstan` analysis, `rector`
refactoring, `php-cs-fixer` formatting, and `phpunit` tests — all run directly
against your module in `/workspace`. There's no nested test project, no
`silverstripe/installer`/`silverstripe/recipe-cms` install, no `public/`
webroot, and nothing forwarded to a browser. That earlier approach pulled in
the full CMS stack (admin, reports, versioned, campaign-admin, etc.) via
`recipe-cms` even though a module that only needs `silverstripe/framework`
never asked for any of that.

Instead: your module's own `composer.json` already declares exactly what it
needs — `require` for runtime deps (e.g. `silverstripe/framework`, not `cms`)
and `require-dev` for the tools above. Running `composer install` in the
module root gives you both, and that's the whole setup.

## 1. Open it in the devcontainer

In VS Code (or a Codespace, or a JetBrains IDE with Dev Containers support):
**Reopen in Container** — or see "Starting the devcontainer manually" below
to drive it directly with the Dev Containers CLI. First build takes a few
minutes: PHP 8.5 with the extensions Silverstripe needs, a MySQL 8 container
for phpunit's database-backed tests, and the Claude Code CLI via the official
[Claude Code Dev Container Feature](https://github.com/anthropics/devcontainer-features/tree/main/src/claude-code).

`postCreateCommand` runs `composer install` in `/workspace` automatically —
nothing else to do before running the tools.

## 2. Run the tools

```bash
vendor/bin/phpunit
vendor/bin/phpstan analyse
vendor/bin/rector process --dry-run     # drop --dry-run to actually apply changes
vendor/bin/php-cs-fixer fix --dry-run --diff   # drop the flags to actually fix
```

If a binary is missing, that tool isn't in this module's `composer.json`
`require-dev` yet. Add whichever ones you need:

```bash
composer require --dev phpstan/phpstan rector/rector friendsofphp/php-cs-fixer
```

(`phpunit/phpunit` is presumably already there, since your `phpunit.xml`
already works.) If you want Silverstripe-aware phpstan rules (understanding
`Config`/`Injector` magic properties and methods) rather than plain PHP
analysis, look at a Silverstripe-specific phpstan extension package and add
it to `phpstan.neon`'s `includes` — worth doing, but a separate decision from
this devcontainer setup.

## 3. The database

`phpunit` tests that touch the ORM (anything extending `SapphireTest`) need a
real database connection — Silverstripe creates a temporary test database
through it at run time. The `db` service in `docker-compose.yml` (MySQL 8)
and the `SS_DATABASE_*` environment variables on the `app` service handle
this automatically; you don't need to do anything for it to work. If you're
sure none of your tests touch the database, you can remove the `db` service
and those env vars entirely to simplify further — ask if you want that cut
down too.

## 4. Everyday workflow

- Edit code under `src/` (or wherever your module's PSR-4 root is) with
  Claude Code's help.
- Re-run whichever of `vendor/bin/phpunit` / `phpstan analyse` / `rector
  process` / `php-cs-fixer fix` is relevant — no flush/rebuild step needed,
  since there's no separate site with its own cached manifest anymore.
- Commit only the module source — `/vendor/` stays out of git per your
  existing `.gitignore`.

## Notes / things worth double-checking for your specific module

- This bundle targets **PHP 8.5** (CMS 6.2+ supports 8.3-8.5), base image
  `php:8.5-cli-bookworm`. That tag is real and published — bookworm (Debian
  12) is fine, no need to move to trixie.
- **If you're building in Zed and see `no such object` on the base image:**
  it's very likely [a known Zed dev container bug](https://github.com/zed-industries/zed/issues/53848)
  where its builder mishandles cross-image `COPY --from=<image>` lines — not
  a missing base image. The Dockerfile installs Composer via the official
  install script instead of `COPY --from=composer:2` specifically to avoid
  triggering it. If you still hit issues in Zed, try
  `"dev_container_use_buildkit": false` in Zed's settings, or drive the build
  with the Dev Containers CLI directly (see below).
- **PHP 8.5 build quirks already worked around in the Dockerfile** — don't
  add these back to `docker-php-ext-install` if you ever touch it:
  - `opcache` is compiled into core as of PHP 8.5 and can't be built as a
    separate module anymore; it's already on by default.
  - `dom`/`xml`/`simplexml`/`xmlreader`/`xmlwriter` are enabled by default in
    any stock PHP build; rebuilding `dom` in isolation is actively broken on
    8.4+ due to how its bundled HTML5/`lexbor` support is wired up.
  - The Dockerfile ends with a `php -r '...'` check that fails the build
    loudly and names anything that's unexpectedly missing.
- If your module also needs to support **CMS 5** (PHP 8.1–8.3), the cleanest
  approach is a second `composer.json` branch (e.g. a `4`/`5` branch with a
  `"silverstripe/framework": "^5"` constraint) plus a CI matrix — the
  devcontainer itself only needs to match whichever branch you're actively
  developing.
- Consider adding `silverstripe/gha-ci` (or your own GitHub Actions config)
  to run the same four commands on every push, so you're not solely relying
  on manually running them in the devcontainer.

## Starting the devcontainer manually (bypassing Zed)

Useful for getting the full, untruncated build log, or for working around
Zed's dev container bugs entirely.

**Quickest — raw `docker compose`, for debugging the Dockerfile build itself:**

```bash
cd your-module   # repo root, not .devcontainer/
docker compose -f .devcontainer/docker-compose.yml build app   # full log, no Zed truncation
docker compose -f .devcontainer/docker-compose.yml up -d
docker compose -f .devcontainer/docker-compose.yml exec app bash
```

This builds and starts exactly what's in `Dockerfile`/`docker-compose.yml` —
`/workspace` is mounted, MySQL is reachable at host `db`. It does **not**
apply devcontainer *Features*, so the Claude Code CLI won't be installed this
way (`docker-compose.yml` alone doesn't know about `devcontainer.json`).

Stop it with `docker compose -f .devcontainer/docker-compose.yml down` (add
`-v` to also wipe the `ss-db-data` volume, i.e. drop the database).

**Full devcontainer-spec compliant — the official Dev Containers CLI**, if you
want Features (Claude Code) and `postCreateCommand` applied just like
Zed/VS Code would, but without Zed's builder:

```bash
npm install -g @devcontainers/cli   # run on your host machine, once
devcontainer up --workspace-folder .
devcontainer exec --workspace-folder . vendor/bin/phpunit
devcontainer exec --workspace-folder . claude
```

`devcontainer up` builds the image, applies the
`ghcr.io/anthropics/devcontainer-features/claude-code` feature, mounts the
workspace, and runs `postCreateCommand`. Re-run
`devcontainer exec --workspace-folder . bash` any time to get a shell. Under
the hood this is the same reference implementation most editors (VS Code,
Codespaces) call into, so if it works here but still fails in Zed, that
confirms the problem is in Zed's own builder rather than the devcontainer
config.

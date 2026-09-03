# Devcontainer setup for a Silverstripe vendor module (static analysis + tests only)

Drop the contents of this bundle into the root of a module repository.

```
your-module/
├── .devcontainer/
│   ├── devcontainer.json
│   ├── docker-compose.yml
│   ├── Dockerfile
│   └── post-create.sh
└── composer.json
```

Your existing `phpunit.xml` and `.gitignore` remain unchanged.

## What this is for

This devcontainer exists for exactly four things: `phpstan` analysis, `rector`
refactoring, `php-cs-fixer` formatting, and `phpunit` tests — all run directly
against the module in `/workspace`.

## 1. Open it in the devcontainer

In an IDE with Dev Containers support):
**Reopen in Container** — or see "Starting the devcontainer manually" below
to drive it directly with the Dev Containers CLI. First build takes a few
minutes: PHP 8.5 with the extensions Silverstripe needs, a MySQL 8 container
for phpunit's database-backed tests, and the Claude Code CLI via the official
[Claude Code Dev Container Feature](https://github.com/anthropics/devcontainer-features/tree/main/src/claude-code).

`postCreateCommand` runs `composer install` in `/workspace` automatically —
nothing else to do before running the tools.

## 2. Run the tools

Tests
```bash
vendor/bin/phpunit
```

Use the helper scripts to run the tools:
```bash
composer run-script phpstan-analyse
composer run-script rector-dryun
composer run-script rector-process
composer run-script phpcsfixer-fix
```

## 3. The database

`phpunit` tests that touch the ORM (anything extending `SapphireTest`) need a
real database connection — Silverstripe creates a temporary test database
through it at run time. The `db` service in `docker-compose.yml` (MySQL 8)
and the `SS_DATABASE_*` environment variables on the `app` service handle
this automatically.

## 4. Everyday workflow

- Edit the module code
- Re-run the relevant tool
- Commit your changes and push

## Starting the devcontainer manually

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
`devcontainer exec --workspace-folder . bash` any time to get a shell.

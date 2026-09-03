# Background

This is a Silverstripe vendor module.

# Instructions

1. Read the README.md file to understand the purpose of this module.
2. Read the docs/en/ markdown files for further documentation

# Layout

Standard Silverstripe vendor module layout:

1. src/ application code
2. tests/ unit and functional tests
3. docs/ further documentation
4. templates/ module templates in .ss format
5. lang/ language strings for i18n
4. _config/ module YML configuration
5. composer.json module requirements, composer configuration, development scripts

Other files are standard configuration files for git, phpunit and composer.

# Paths and commands

- Run tests: `./vendor/bin/phpunit`
- Run PHPStan static analysis via composer script: `composer run-script phpstan-analyse`
- Run Rector dry run via composer script: `composer run-script rector-dryrun`
- Run Rector process via composer script: `composer run-script rector-process`
- Run PhpCSFixer fix via composer script: `composer run-script phpcsfixer-fix`

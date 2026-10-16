# Download

Display downloads. This package is an extension to the TYPO3 system.

### Installation

* This is (not yet) available as composer package on packagist.org. Please add
  the repo url to your root composer json first.

```
composer config repositories.cps-download vcs \
    git@github.com:CPS-IT/cps-download.git
```

```
composer require cpsit/cps-download
```

## Actions / Views

### List selected Downloads

Displays a list of selected Downloads items in frontend. If no, Downloads item
ist selected nothing will be displayed.

**Action**: listSelectedAction

**Cache**: Cacheable

### List Downloads

Displays a list of  Downloads items in frontend sorted by weight. Editors are
able to filter the results by category.
Editors have the possibility to enable or disable the search form in front end.
**Important**: _Search and filters have to be done with Ajax_.

**Action**: listSelectedAction

**Cache**: Cacheable

## Code quality

Run in the DDEV project (see Tests), prefix with `ddev`:

```
ddev composer lint   # composer.json, EditorConfig, PHP-CS-Fixer, TypoScript
ddev composer fix    # fix the findings that can be fixed automatically
ddev composer sca    # PHPStan, level 6
```

## Tests

Tests and code quality tools run in the package's own DDEV project
(`.ddev/config.yaml`: PHP 8.4, MariaDB 10.11, hostname
`cps-download.ddev.site`). The functional tests use the database named in the
`typo3Database*` variables of the DDEV config. The private repositories
`cpsit/cps-utility` and `cpsit/cps-author` need your SSH key in the container:
run `ddev auth ssh` once.

```
ddev auth ssh
ddev start
ddev composer install
```

### Unit Tests

```
ddev composer test:unit
```

### Functional Tests

```
ddev composer test:functional
```

# Download

Display downloads. This package is an extension to the TYPO3 system.

### Installation

* This is (not yet) available as composer package on packagist.org. Please add the repo url to your root composer json first.

```
composer config repositories.cps-download vcs  git@github.com:CPS-IT/cps-download.git
```

```
composer require cpsit/cps-download 
```

## Actions / Views

### List selected Downloads

Displays a list of selected Downloads items in frontend. If no, Downloads item ist selected nothing will be displayed.

**Action**: listSelectedAction

**Cache**: Cacheable

### List Downloads

Displays a list of  Downloads items in frontend sorted by weight. Editors are able to filter the results by category. 
Editors have the possibility to enable or disable the search form in front end. **Important**: _Search and filters have to be done with Ajax_.

**Action**: listSelectedAction

**Cache**: Cacheable

## Tests

### Setup Test Environment 

```
docker-composer -f Tests/Build/docker-compose.yml up -d
docker-compose -f Tests/Build/docker-compose.yml exec web bash -c "cd /app && composer test:functional:prepare"
```

### Unit Tests

```
docker-compose -f Tests/Build/docker-compose.yml exec web bash -c "cd /app && composer test:unit"
```

### Functional Tests

```
docker-compose -f Tests/Build/docker-compose.yml exec web bash -c "cd /app && composer test:functional:run"
```

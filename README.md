# Location Finder Module

The Location Finder module allows users to search for locations by entering a country, city, and postal code. The module interacts with the API to fetch the locations and filters out locations that do not operate on weekends or have odd street numbers. The filtered results are displayed in YAML format.

## Requirements

- Drupal 10.x
- PHP 8.x
- Guzzle HTTP client
- YAML PHP library

## Installation

1. Clone the repository into your Drupal site's `modules/custom` directory:

   git clone <repository-url> modules/custom/location_finder

2. Navigate to your Drupal site's root directory and run the following commands to install the required dependencies:

   composer require guzzlehttp/guzzle symfony/yaml

3. Enable the module:

   drush en location_finder

## Usage

1. Navigate to the module's page: `/<Drupal root url>/location-finder`.
2. Enter the required information:
   - Country
   - City
   - Postal Code
3. Click the "Search" button.
4. The filtered list of locations will be displayed in YAML format.

## Example

For example, entering the following details:

- Country: `DE`
- City: `Dresden`
- Postal Code: `01067`

Will result in a YAML formatted list of locations in DE, Dresden, that operate on weekends and do not have odd street numbers.

## Development

### Directory Structure

modules/custom/location_finder/
├── src/
│ ├── Controller/
│ │ └── LocationFinderController.php
│ ├── Form/
│ │ └── LocationFinderForm.php
├── tests/
│ ├── src/
│ │ └── Unit/
│ │ └── LocationFinderControllerTest.php
├── location_finder.info.yml
├── location_finder.routing.yml
├── location_finder.module
└── README.md

### module

In this file you have to define the constant values which will be used to store the api key and url.

define('DHL_LOCATION_FINDER_API_KEY', '');
define('DHL_LOCATION_FINDER_URL', '');

### Controller

The `LocationFinderController` is the main controller that handles the form submission, makes the request to the API, filters the results, and returns the output in YAML format.

### Unit Tests

The module includes unit tests to verify the functionality of the `filterLocations` method.

### phpunit.xml.dist

Create this file on root of your Drupal directory with below content

<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="core/tests/bootstrap.php">
  <testsuites>
    <testsuite name="Unit Tests">
      <directory>modules/custom/location_finder/tests/src/Unit</directory>
    </testsuite>
  </testsuites>
</phpunit>

#### Running Tests

To run the tests, navigate to your Drupal site's root directory and execute:

vendor/bin/phpunit -c core modules/custom/location_finder/tests/src/Unit

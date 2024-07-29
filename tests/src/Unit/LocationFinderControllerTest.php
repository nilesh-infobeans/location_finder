<?php

namespace Drupal\Tests\location_finder\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\location_finder\Controller\LocationFinderController;
use Symfony\Component\Yaml\Yaml;

/**
 * Unit tests for the LocationFinderController class.
 *
 * @group location_finder
 */
class LocationFinderControllerTest extends UnitTestCase
{
  /**
   * Tests the filterLocations() method.
   */
    public function testFilterLocations()
    {
      // Instantiate the controller.
        $controller = new LocationFinderController();

      // Mock locations data.
        $locations = [
        [
        'url' => '/locations/8003-4302734',
        'openingHours' => [
          [
            'opens' => '09:30:00',
            'closes' => '20:00:00',
            'dayOfWeek' => 'http://schema.org/Saturday',
          ],
          [
            'opens' => '09:30:00',
            'closes' => '20:00:00',
            'dayOfWeek' => 'http://schema.org/Sunday',
          ],
        ],
        ],
        [
        'url' => '/locations/8003-4311767',
        'openingHours' => [
          [
            'opens' => '09:30:00',
            'closes' => '20:00:00',
            'dayOfWeek' => 'http://schema.org/Monday',
          ],
        ],
        ],
        ];

      // Expected filtered results.
        $expected_filtered = [
        [
        'url' => '/locations/8003-4302734',
        'openingHours' => [
          [
            'opens' => '09:30:00',
            'closes' => '20:00:00',
            'dayOfWeek' => 'http://schema.org/Saturday',
          ],
          [
            'opens' => '09:30:00',
            'closes' => '20:00:00',
            'dayOfWeek' => 'http://schema.org/Sunday',
          ],
        ],
        ],
        ];

      // Call the method and get the filtered locations.
        $filtered_locations = $controller->filterLocations($locations);

      // Convert to YAML for easy comparison.
        $filtered_yaml = Yaml::dump($filtered_locations, 2, 4, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
        $expected_yaml = Yaml::dump($expected_filtered, 2, 4, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);

      // Assert that the filtered locations match the expected results.
        $this->assertEquals($expected_yaml, $filtered_yaml);
    }
}

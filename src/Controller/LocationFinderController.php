<?php

namespace Drupal\location_finder\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\Yaml\Yaml;

class LocationFinderController extends ControllerBase
{
    public function locations($country, $city, $postal_code)
    {
        try {
            $client = \Drupal::httpClient();
            $api_key = DHL_LOCATION_FINDER_API_KEY;
            $url = DHL_LOCATION_FINDER_URL;
            $api_response1 = $client->request('GET', $url, [
            'headers' => [
            'DHL-API-Key' => $api_key,
            ],
            'query' => [
            'countryCode' => $country,
            'addressLocality' => $city,
            'postalCode' => $postal_code,
            ],
            ]);
            $response_body = (string) $api_response1->getBody();
            \Drupal::logger('location')->debug('API response body: @body', ['@body' => $response_body]);

          // Decode the response body
            $data = json_decode($response_body, true);

            $filtered_data = $this->filterLocations($data['locations']);
            $yaml_output = Yaml::dump($filtered_data, 2, 4, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);

            return new Response('<pre>' . htmlspecialchars($yaml_output) . '</pre>');
        } catch (RequestException $e) {
            return new Response('<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>');
        }
    }

    public function filterLocations(array $locations)
    {
        $filtered = [];

        foreach ($locations as $location) {
          // Extract the location ID using regex
            preg_match('/\/locations\/([0-9\-]+)/', $location['url'], $matches);
          // Get the location ID
            $street_number = str_replace("-", "", $matches[1]);
          // Check if the location operates on weekends
            $opening_hours = $this->extractOpeningHours($location['openingHours']);
            if (isset($opening_hours['Saturday']) && isset($opening_hours['Sunday']) && ($street_number % 2 == 0)) {
                $filtered[] = $location;
            }
        }

        return $filtered;
    }

    public function extractOpeningHours(array $openingHours)
    {
        $hours = [];

        foreach ($openingHours as $entry) {
            $dayOfWeek = basename($entry['dayOfWeek']);
            $hours[$dayOfWeek] = [
            'opens' => $entry['opens'],
            'closes' => $entry['closes'],
            ];
        }

        return $hours;
    }
}

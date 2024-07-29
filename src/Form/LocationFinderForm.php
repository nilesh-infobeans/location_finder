<?php

namespace Drupal\location_finder\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

class LocationFinderForm extends FormBase
{
  /**
   * {@inheritdoc}
   */
    public function getFormId()
    {
        return 'location_finder_form';
    }

  /**
   * {@inheritdoc}
   */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['country'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Country'),
        '#required' => true,
        ];
        $form['city'] = [
        '#type' => 'textfield',
        '#title' => $this->t('City'),
        '#required' => true,
        ];
        $form['postal_code'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Postal Code'),
        '#required' => true,
        ];
        $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Find Locations'),
        ];

        return $form;
    }

  /**
   * {@inheritdoc}
   */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $country = $form_state->getValue('country');
        $city = $form_state->getValue('city');
        $postal_code = $form_state->getValue('postal_code');

        $url = Url::fromRoute('location_finder.locations', [
        'country' => $country,
        'city' => $city,
        'postal_code' => $postal_code,
        ]);

        $response = new RedirectResponse($url->toString());
        $response->send();
    }
}

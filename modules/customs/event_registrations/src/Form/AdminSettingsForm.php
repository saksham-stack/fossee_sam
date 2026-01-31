<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure event registration settings.
 */
class AdminSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'event_registration.settings';

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new AdminSettingsForm.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'event_registration_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    $site_config = $this->configFactory->get('system.site');
    $site_email = $site_config->get('mail');

    $form['notification_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Email Notification Settings'),
      '#open' => TRUE,
    ];

    $form['notification_settings']['admin_notifications_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable admin notifications'),
      '#description' => $this->t('When enabled, administrators will receive email notifications for new event registrations.'),
      '#default_value' => $config->get('admin_notifications_enabled') ?? TRUE,
    ];

    $form['notification_settings']['admin_notification_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Admin notification email'),
      '#description' => $this->t('Email address where registration notifications will be sent. Leave empty to use the site email (@site_email).', [
        '@site_email' => $site_email ?: $this->t('not configured'),
      ]),
      '#default_value' => $config->get('admin_notification_email'),
      '#states' => [
        'visible' => [
          ':input[name="admin_notifications_enabled"]' => ['checked' => TRUE],
        ],
        'required' => [
          ':input[name="admin_notifications_enabled"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['notification_settings']['email_help'] = [
      '#type' => 'item',
      '#markup' => '<div class="messages messages--info">' . 
        $this->t('<strong>Note:</strong> Make sure your server is configured to send emails. You can test email delivery by submitting a test registration.') . 
        '</div>',
    ];

    $form['registration_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Registration Settings'),
      '#open' => TRUE,
    ];

    $form['registration_settings']['info'] = [
      '#type' => 'item',
      '#markup' => '<p>' . 
        $this->t('Additional registration settings can be added here in future updates.') . 
        '</p>',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $admin_email = $form_state->getValue('admin_notification_email');
    $notifications_enabled = $form_state->getValue('admin_notifications_enabled');

    if ($notifications_enabled && !empty($admin_email)) {
      if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
        $form_state->setErrorByName('admin_notification_email', 
          $this->t('Please enter a valid email address.'));
      }
    }

    if ($notifications_enabled && empty($admin_email)) {
      $site_config = $this->configFactory->get('system.site');
      $site_email = $site_config->get('mail');
      
      if (empty($site_email)) {
        $form_state->setErrorByName('admin_notification_email', 
          $this->t('Please provide an admin email address or configure the site email at <a href="@url">Site Information</a>.', [
            '@url' => '/admin/config/system/site-information',
          ]));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    
    $config
      ->set('admin_notifications_enabled', $form_state->getValue('admin_notifications_enabled'))
      ->set('admin_notification_email', $form_state->getValue('admin_notification_email'))
      ->save();

    \Drupal::logger('event_registration')->info(
      'Admin settings updated. Notifications: @status, Email: @email',
      [
        '@status' => $form_state->getValue('admin_notifications_enabled') ? 'Enabled' : 'Disabled',
        '@email' => $form_state->getValue('admin_notification_email') ?: 'Using site default',
      ]
    );

    parent::submitForm($form, $form_state);
  }

}
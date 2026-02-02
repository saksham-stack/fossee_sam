<?php

namespace Drupal\event_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RegistrationListForm extends FormBase {

  protected Connection $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  public function getFormId() {
    return 'event_registration_list_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $header = [
      'name' => $this->t('Name'),
      'email' => $this->t('Email'),
      'college' => $this->t('College'),
      'department' => $this->t('Department'),
      'created' => $this->t('Submitted On'),
    ];

    $rows = [];

    $result = $this->database->select('event_registration_entry', 'r')
      ->fields('r', ['first_name', 'last_name', 'email', 'college', 'department', 'created'])
      ->execute();

    foreach ($result as $record) {
      $rows[] = [
        'name' => $record->first_name . ' ' . $record->last_name,
        'email' => $record->email,
        'college' => $record->college,
        'department' => $record->department,
        'created' => date('Y-m-d H:i', $record->created),
      ];
    }

    $form['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No registrations found.'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {}
}

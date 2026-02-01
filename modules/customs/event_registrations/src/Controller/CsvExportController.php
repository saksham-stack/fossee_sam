<?php

namespace Drupal\event_registration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CsvExportController extends ControllerBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a new CsvExportController object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Exports event registrations to CSV format.
   *
   * @param int|null $event_id
   *   Optional event ID to filter registrations.
   *
   * @return \Symfony\Component\HttpFoundation\StreamedResponse
   *   The CSV response.
   */
  public function export($event_id = NULL) {
    $filename = 'event_registrations_' . date('Y-m-d_H-i-s') . '.csv';
    
    $response = new StreamedResponse();
    $response->setCallback(function() use ($event_id) {
      $handle = fopen('php://output', 'w');
      
      // Add UTF-8 BOM for proper character encoding in Excel
      fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
      
      // Define headers for the CSV
      $headers = [
        $this->t('ID'),
        $this->t('Event Name'),
        $this->t('Full Name'),
        $this->t('Email'),
        $this->t('College'),
        $this->t('Department'),
        $this->t('Registration Date'),
      ];
      
      fputcsv($handle, $headers);
      
      // Build the query to fetch registration data
      $query = $this->database->select('event_registration_entry', 'ere');
      $query->join('event_registration_event', 'erev', 'ere.event_id = erev.id');
      $query->fields('ere', ['id', 'full_name', 'email', 'college', 'department', 'created']);
      $query->addField('erev', 'event_name', 'event_name');
      $query->orderBy('ere.created', 'DESC');
      
      // Filter by event ID if provided
      if ($event_id) {
        $query->condition('ere.event_id', $event_id);
      }
      
      $results = $query->execute();
      
      // Process each registration record
      foreach ($results as $record) {
        $row = [
          $record->id,
          $record->event_name,
          $record->full_name,
          $record->email,
          $record->college,
          $record->department,
          date('Y-m-d H:i:s', $record->created),
        ];
        
        fputcsv($handle, $row);
      }
      
      fclose($handle);
    });
    
    $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
    $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
    
    return $response;
  }
  
  /**
   * Exports registrations for a specific event to CSV.
   *
   * @param int $event_id
   *   The event ID to export registrations for.
   *
   * @return \Symfony\Component\HttpFoundation\StreamedResponse
   *   The CSV response.
   */
  public function exportByEvent($event_id) {
    return $this->export($event_id);
  }
  
  /**
   * Exports all registrations to CSV.
   *
   * @return \Symfony\Component\HttpFoundation\StreamedResponse
   *   The CSV response.
   */
  public function exportAll() {
    return $this->export(NULL);
  }
}
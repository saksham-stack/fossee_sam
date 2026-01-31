<?php

namespace Drupal\event_registration\Controller;

use Symfony\Component\HttpFoundation\Response;

class CsvExportController {

  public function export() {
    return new Response('CSV export placeholder');
  }

}

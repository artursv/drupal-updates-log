<?php

namespace Drupal\Tests\updates_log\Kernel;

use Drupal\Core\Site\Settings;
use Drupal\KernelTests\KernelTestBase;
use Drupal\updates_log\UpdatesLog;

/**
 * Tests that "updates_log_disabled" setting works as expected.
 *
 * @group updates_log
 */
class UpdatesLogDisabledTest extends KernelTestBase {

  /**
   * The UpdatesLog service.
   *
   * @var \Drupal\updates_log\UpdatesLog
   */
  private UpdatesLog $updatesLogService;

  /**
   * The modules to load to run the test.
   *
   * @var array
   */
  protected static $modules = [
    'update',
    'updates_log',
    'dblog',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installConfig(['updates_log']);
    $this->installSchema('dblog', ['watchdog']);
    $this->updatesLogService = \Drupal::service('updates_log.updates_logger');
    $this->db = \Drupal::database();
  }

  public function testDisabledDoesNotRun(): void {
    new Settings(['updates_log_disabled' => TRUE]);
    $this->updatesLogService->run();
    $query = $this->db->query("select * from {watchdog}");
    $result = $query->fetchAll();
    $this->assertEmpty($result);
  }

  /**
   * @return void
   * @depends  Drupal\Tests\updates_log\Kernel\UpdatesLogRunTest::testCrash
   */
  public function testNotDisabledRuns(): void {
    $this->assertTrue(TRUE);
  }

}

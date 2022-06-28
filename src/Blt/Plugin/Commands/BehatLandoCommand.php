<?php

namespace Acquia\BltLando\Blt\Plugin\Commands;

use Acquia\BltBehat\Blt\Plugin\Commands\BehatTestCommand;
use Acquia\Blt\Robo\Common\EnvironmentDetector;

class BehatLandoCommand extends BehatTestCommand {

  /**
   * Lando specific overrides for BLT Behat command.
   *
   * @hook replace-command tests:behat:run
   *
   * {@inheritdoc}
   */
  public function behat(){
    parent::initialize();
    parent::setupBehat();
    // Fallback to original Behat command unless lando is enabled.
    if (!$this->getConfigValue('lando.enable') || EnvironmentDetector::isCiEnv()) {
      parent::behat();
    }
    else {
      // Log config for debugging purposes.
      $this->logConfig($this->getConfigValue('behat'), 'behat');
      $this->logConfig($this->getInspector()->getLocalBehatConfig()->export());
      $this->createReportsDir();

      try {
        $this->launchDocker();
        $this->executeBehatTests();
      }
      catch (\Exception $e) {
        // Kill web driver a server to prevent Pipelines from hanging after fail.
        $this->killWebDriver();
        throw $e;
      }
    }
  }

  /**
   * Launches a Docker-based chrome process.
   */
  protected function launchDocker() {
    $this->logger->info("Launching Docker Chrome Container...");
    $this->getContainer()
      ->get('executor')
      ->execute("nohup docker run -d -p 9222:9222 --cap-add=SYS_ADMIN isholgueras/chrome-headless")
      ->background(TRUE)
      ->printOutput(TRUE)
      ->printMetadata(TRUE)
      ->run();
  }
}

<?php

namespace Acquia\BltLando\Blt\Plugin\Commands;

use Acquia\Blt\Robo\BltTasks;
use Acquia\Blt\Robo\Common\YamlWriter;
use Acquia\Blt\Robo\Exceptions\BltException;
use Robo\Contract\VerbosityThresholdInterface;

/**
 * Defines commands related to Lando.
 */
class LandoCommand extends BltTasks {

  /**
   * Initializes default Lando configuration for this project.
   *
   * @command recipes:vm:lando
   * @throws \Acquia\Blt\Robo\Exceptions\BltException
   */
  public function landoInit() {
    $this->machineName = $this->getConfigValue('project.machine_name');
    $this->hostName = $this->getConfigValue('project.local.hostname');
    $this->vmConfig = $this->getConfigValue('repo.root') . '/.lando.yml';
    $result = $this->taskFilesystemStack()
      ->copy($this->getConfigValue('repo.root') . '/vendor/mikemadison13/blt-lando/.lando.yml', $this->vmConfig, TRUE)
      ->stopOnFail()
      ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_VERBOSE)
      ->run();
    $this->taskReplaceInFile($this->vmConfig)
      ->from('<host_name>')
      ->to($this->hostName)
      ->run();
    $this->taskReplaceInFile($this->vmConfig)
      ->from('<machine_name>')
      ->to($this->machineName)
      ->run();

    if (!$result->wasSuccessful()) {
      throw new BltException("Could not initialize Lando configuration.");
    }

    $this->say("<info>A pre-configured GLando file was copied to your repository root. Please customize as needed then run <comment>lando start</comment>.</info>");
  }

}

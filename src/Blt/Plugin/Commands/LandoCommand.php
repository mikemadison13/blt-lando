<?php

namespace Acquia\BltLando\Blt\Plugin\Commands;

use Acquia\Blt\Robo\BltTasks;
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
   *
   * @throws \Acquia\Blt\Robo\Exceptions\BltException
   */
  public function landoInit() {
    $this->machineName = $this->getConfigValue('project.machine_name');
    $this->hostName = $this->getConfigValue('project.local.hostname');
    $this->vmConfig = $this->getConfigValue('repo.root') . '/.lando.yml';
    $this->projectReadme = $this->getConfigValue('repo.root') . '/README.md';

    // Creat .lando.yml file.
    $result = $this->taskFilesystemStack()
      ->copy($this->getConfigValue('repo.root') . '/vendor/mikemadison13/blt-lando/.lando.yml', $this->vmConfig, FALSE)
      ->stopOnFail()
      ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_VERBOSE)
      ->run();

    if (!$result->wasSuccessful()) {
      throw new BltException("Could not initialize Lando configuration.");
    }

    // Place php.ini for XDebug.
    $result = $this->taskFilesystemStack()
      ->copy(
            $this->getConfigValue('repo.root') . '/vendor/mikemadison13/blt-lando/config/php.ini',
            $this->getConfigValue('repo.root') . '/.lando/php.ini', FALSE)
      ->stopOnFail()
      ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_VERBOSE)
      ->run();

    if (!$result->wasSuccessful()) {
      throw new BltException("Could not copy php.ini for XDebug configuration.");
    }

    // Create a project README file with Lando and BLT steps.
    $result = $this->taskFilesystemStack()
      ->copy($this->getConfigValue('repo.root') . '/vendor/mikemadison13/blt-lando/example-README.md', $this->getConfigValue('repo.root') . '/README.md', FALSE)
      ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_VERBOSE)
      ->run();
    if (!$result->wasSuccessful()) {
      throw new BltException("Could not copy example.README.md template to project folder.");
    }

    $this->taskReplaceInFile($this->vmConfig)
      ->from('<host_name>')
      ->to($this->hostName)
      ->run();
    $this->taskReplaceInFile($this->vmConfig)
      ->from('<machine_name>')
      ->to($this->machineName)
      ->run();
    $this->taskReplaceInFile($this->projectReadme)
      ->from('<machine_name>')
      ->to($this->machineName)
      ->run();

    // Copy BLT local config template (aka example.local.blt.yml).
    $result = $this->taskFilesystemStack()
      ->copy($this->getConfigValue('repo.root') . '/vendor/mikemadison13/blt-lando/config/blt/example.local.blt.yml', $this->getConfigValue('repo.root') . '/blt/example.local.blt.yml', FALSE)
      ->copy($this->getConfigValue('repo.root') . '/vendor/mikemadison13/blt-lando/config/blt/local.blt.yml', $this->getConfigValue('repo.root') . '/blt/local.blt.yml', FALSE)
      ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_VERBOSE)
      ->run();

    if (!$result->wasSuccessful()) {
      throw new BltException("Could not copy example.local.blt.yml template to blt folder.");
    }

    // Initialize local settings.
    try {
      $result = $this->taskFilesystemStack()
        // @todo Add multisite local settings support as in blt:init:settings.
        ->remove($this->getConfigValue('repo.root') . '/blt/local.blt.yml')
        ->remove($this->getConfigValue('drupal.local_settings_file'))
        ->remove($this->getConfigValue('docroot') . '/sites/default/local.drush.yml')
        ->stopOnFail()
        ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_VERBOSE)
        ->run();

      if (!$result->wasSuccessful()) {
        throw new BltException("Could not remove old local settings. Please check your permissions.");
      }

      // Re-init settings after old settings are removed.
      $this->invokeCommand('blt:init:settings');

      $this->taskReplaceInFile($this->getConfigValue('docroot') . '/sites/default/settings/local.settings.php')
        ->from('\'drupal\'')
        ->to('\'acquia\'')
        ->run();
      $this->taskReplaceInFile($this->getConfigValue('docroot') . '/sites/default/settings/local.settings.php')
        ->from("host' => 'localhost',")
        ->to("host' => 'database',")
        ->run();
    }

    catch (BltException $e) {
      throw new BltException("Could not init local BLT or settings files.");
    }

    $this->say("<info>A pre-configured Lando file was copied to your repository root. Please customize as needed then run <comment>lando start</comment>.</info>");
  }

}

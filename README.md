Acquia BLT Lando integration
====

This is an [Acquia BLT](https://github.com/acquia/blt) plugin providing [Lando](https://lando.dev/) integration.

This plugin is **community-created** and **community-supported**. Acquia does not provide any direct support for this software or provide any warranty as to its stability.

## Installation and usage

To use this plugin, you must already have a Drupal project using BLT 11 (or higher).

In your project, require the plugin with Composer:

`composer require mikemadison13/blt-lando`

Initialize the Gitlab integration by calling `blt recipes:vm:lando`, which is provided by this plugin.

This will copy a template version of the .lando.yml to your project root directory. Make sure to commit this as well as your updated composer.json to Git.

Note: the template YAML file assumes standard BLT steps for builds and is based upon the drupal8 community image. The plugin will attempt to customize the file based on your project's machine and host names as defined in your blt.yml file.

Please carefully review the created .lando.yml file prior to running `lando start`

# License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License version 2 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

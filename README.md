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

## Adding Solr

The .lando.yml file included with this plugin does not include an Apache Solr service by default because not all projects need Solr!

However, if you wish to use Solr, simply add an additional service to the .lando.yml file like the following:

```yaml
services:
  solr:
    type: solr:7.7
    core: drupal
    portforward: true
```

Then rebuild your VM using `lando rebuild`.

Note that for Search API you'll need the following information:

Connector: standard
scheme: http
host: solr
port: 8983
path: /
core: drupal 

notes: 
* the core is configurable so if you want it to be something else, change the core definition in the service definition and update the solr config to be the same!
* the internal / localhost connectivity for the server is NOT the same as the service url that lando will report (and that's ok)
* even though Search API ships a config file, I have not been able to get the solr service to recognize and pull the config file from the appserver (so there is not currently a config path here)

# License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License version 2 as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

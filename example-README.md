# My Project
This repository consists of the <machine_name>.

# Getting Started
This project is based on BLT 12.x with Lando local env, an open-source project template and tool that enables building, testing, and deploying Drupal installations following Acquia Professional Services best practices. While this is one of many methodologies, it is our recommended methodology.

1. Review the [Required / Recommended Skills](https://docs.acquia.com/blt/developer/skills/) for working with a BLT project.
2. Ensure that your computer meets the minimum installation requirements (and then install the required applications). See the [System Requirements](https://docs.acquia.com/blt/install/).

# If Starting From Scratch 
1. Download the latest version of Drupal
```
$ composer create-project --no-interaction acquia/drupal-recommended-project <machine_name>
```

2. Confirm BLT is added as a composer dependency 
```
$ composer require acquia/blt:^12.0 --no-update
```

3. Add the blt-lando plugin
```
$ composer require mikemadison13/blt-lando
```

4. Run composer update 
```
$ composer update
```

5. Setup your container settings by modifying your .lando.yml file. 
```
$ blt recipes:vm:lando
```


# Working from an existing project
1. Request access to organization that owns the project repo in GitHub (if needed).
2. Fork the project repository in GitHub.
3. Request access to the Acquia Cloud Environment for your project (if needed).
4. Setup a SSH key that can be used for GitHub and the Acquia Cloud (you CAN use the same key).
    1. [Setup GitHub SSH Keys](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)
    2. [Setup Acquia Cloud SSH Keys](https://docs.acquia.com/acquia-cloud/ssh/generate)
5. Clone your forked repository. By default, Git names this "origin" on your local.
```
$ git clone git@github.com:<account>/<machine_name>.git
```
6. To ensure that upstream changes to the parent repository may be tracked, add the upstream locally as well.
```
$ git remote add upstream git@github.com:acquia-pso/<machine_name>.git
```

7. Install Composer dependencies.
After you have forked, cloned the project and setup your blt.yml file install Composer Dependencies. (Warning: this can take some time based on internet speeds.)
```
$ composer install
```
8. Setup Lando.
Setup the container by modifying your .lando.yml  with the configuration from this repositories [configuration files](#important-configuration-files).
```
$ lando start
```

9. Setup a local Drupal site with an empty database.
Use BLT to setup the site with configuration.  If it is a multisite you can identify a specific site.
```
$ lando blt setup
```
or
```
$ lando blt setup --site=[sitename]
```

10. Log into your site with drush.
Access the site and do necessary work at #LOCAL_DEV_URL by running the following commands.
```
$ cd web
$ lando drush uli
```

---
## Other Local Setup Steps

1. Set up frontend build and theme.
By default BLT sets up a site with the lightning profile and a cog base theme. You can choose your own profile before setup in the blt.yml file. If you do choose to use cog, see [Cog's documentation](https://github.com/acquia-pso/cog/blob/8.x-1.x/STARTERKIT/README.md#create-cog-sub-theme) for installation.
See [BLT's Frontend docs](https://docs.acquia.com/blt/developer/frontend/) to see how to automate the theme requirements and frontend tests.
After the initial theme setup you can configure `blt/blt.yml` to install and configure your frontend dependencies with `blt setup`.

2. Pull Files locally.
Use BLT to pull all files down from your Cloud environment.
```
$ lando blt drupal:sync:files
```

3. Sync the Cloud Database.
If you have an existing database you can use BLT to pull down the database from your Cloud environment.
```
$ lando blt sync
```

---
# To start developing every time 

1. Pull from the github repository 
```
git pull upstream develop
```

2. Create a new feature branch from develop
```
git checkout -b JIRA-000-feature-branch
```

3. Install Composer dependencies.
After you have forked, cloned the project and setup your blt.yml file install Composer Dependencies. (Warning: this can take some time based on internet speeds.)
```
$ composer install
```
4. Setup container 
```
$ lando start
```

5. Setup a local Drupal site with an empty database. The blt-cohesion composer package will run all necessary site studio commands. 
Use BLT to setup the site with configuration.
```
$ lando blt setup
```
or  If it is a multisite you can identify a specific site.
```
$ lando blt setup --site=<machine_name>
```

6. Log into your site with drush.
Access the site and do necessary work at #LOCAL_DEV_URL by running the following commands.
```
$ cd docroot
$ lando drush uli
```
    


### To Create a Pull Request. 

1. After you make changes inside your local drupal site. Export your configuration from the database to your configuration. 
 Export your drupal config changes if you have them. 
 ```
$ lando drush cex
```
To export Site studio configuration to your site studio package run the following command.
 ```
$ lando drush sync:export
```

2. commit your changes and push your changes to your origin repository. 
```
$ git status
$ git add -p
$ git commit -m"<machine_name>-000: Committing new changes to site."
$ git push --set-upstream origin <machine_name>-000-new-site-change
```

3. Navigate to Github and open a pull request against the upstream. Assign a person on your team to review.
  


# Resources

Additional [BLT documentation](https://docs.acquia.com/blt/) may be useful. You may also access a list of BLT commands by running this:
```
$ blt
```

Note the following properties of this project:
* Primary development branch: Develop
* Local site URL: http://<machine_name>.lndo.site

## Working With a BLT Project
BLT projects are designed to instill software development best practices (including git workflows). \
Our BLT Developer documentation includes an [example workflow](https://docs.acquia.com/blt/developer/dev-workflow/).

### Important Configuration Files
BLT uses a number of configuration (`.yml` or `.json`) files to define and customize behaviors. Some examples of these are:

* `blt/blt.yml` (formerly blt/project.yml prior to BLT 9.x)
* `blt/local.blt.yml` (local only specific blt configuration)
* `landio.yml` (Lando configuration)
* `drush/sites` (contains Drush aliases for this project)
* `composer.json` (includes required components, including Drupal Modules, for this project)

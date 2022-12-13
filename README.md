Magento 2 Base
==============

The `Iods_Base` module is a core module container for extending and testing general functionality
across Magento 2. This includes some common files needed for registering the API as well as a few 
components for understanding the overall Magento 2 API structure. 

Functionality provided by this module includes:

 * A main container for additional modules to utilize, mainly Helpers
 * Adminhtml section for configuration support

**This is a private module and is not currently maintained for public use.**


Facts
-----

 * Version: 0.1.1 (Development)
 * [Composer Package](https://packagist.org/packages/iods/module-base)
 * [Repository on Github](https://github.com/iods/magento2-base)


Getting Started
---------------

#### Download Zip

Download a release.

#### Through Composer

Working on this.


### Requirements

 * [Magento <= 2.4]()
 * [Git](http://git-scm.com)
 * [PHP v7.4+](http://php.net)
 * [Composer](http://getcomposer.org)


### Known Issues

 * Link to any Github issues, or list issues w/ Magento 2 compatibility or Extension compatibility
 * Provides main container for other Iods modules to extend from and utilize, including ACL
 * Displays `APP_MODE` for developers working in multiple environments with store version and Magento version (quick reference)
 * CRUD model for saving data and other packages to extend from
 * System configuration entry with frontend display
 * Installation scripts to install tables and insert sample data for the module
 * Un-installation scripts to properly remove the extension
 * Adminhtml UiComponent Form and Grids with admin entry management
 * Fixes some Magento 2 issues w/ Plugins and Observers
 * Cron for clearing X
 * Report check and notify
 * adds some helpers for other modules to use


## Related Projects / Tickets / Stories

If you use your module internally, try to add links to related documentation covered in projects or tickets.

* [#00000](https://yourProjectManagementSystem.com/yourTicketNumber) - Task Title goes here
* [#00001](https://yourProjectManagementSystem.com/yourTicketNumber) - Task Title goes here
* [#00002](https://yourProjectManagementSystem.com/yourTicketNumber) - Task Title goes here
* [#00003](https://yourProjectManagementSystem.com/yourTicketNumber) - Task Title goes here
* [#00004](https://yourProjectManagementSystem.com/yourTicketNumber) - Task Title goes here
* [#00005](https://yourProjectManagementSystem.com/yourTicketNumber) - Task Title goes here


### Installation

Includes a series of step-by-step examples for installation and configuration.

```
$ composer require iods/module-performance
$ bin/magento module:enable Iods_Performance
$ bin/magento setup:upgrade
$ bin/magento cache:flush 

$ bin/magento config:set dev/js/minify_files 1 -l
$ bin/magento config:set dev/js/merge_files 1 -l
$ bin/magento config:set dev/css/minify_files 1 -l
$ bin/magento config:set dev/css/merge_css_files 0 -l
$ bin/magento config:set dev/template/minify_html 1 -l
$ bin/magento deploy:mode:set production
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Your Framework](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Your Dependency Management](https://maven.apache.org/) - Dependency Management
* [Other Tools, you use](https://rometools.github.io/rome/) - Any Kind of Generator for example

## Magento 2

### Components

Explain how you made you module. Did you make use of Plugins or Observers? Where is the entry point of the module.

* Minify HTML code
* Lazy load Iframes, Images
* Defer/preload CSS files by using javascript/browser preload
* Minify inline CSS, Javascript
* Move javascript to footer
* Defer javascript codes
* Adding https/2 push
* Preload fonts

### Extensions

Explain how to extend your module.

```
Give an example
```

### Configurations

Give an overview of the given configurations.

You have to disable merge css if you want to use CSS modifier functions.

| Section | Group | Field | Description | 
| ------ | ----- | ----- | ----------- |
| web | default | cms_home_page | Select the CMS Home Page |
| web | default| cms_no_route | Select the 404 Page |
| web | default | cms_no_cookies | Select the No Cookies Page |

Development
-----------

### Structure

How does it work? What components in the module exist. What is different. Link to devdocs.

Finishing w/ an example of system information of demo of the module for your team.


### Extensibility

Includes a series of step-by-step examples for extending the module and code snippets of the extension points.

#### Events

A list of events dispatched by the module.

#### Layouts

Does it introduce layouts or layout handles?


### UI Components

Does the module introduce any UI components or the configuration files, where are they?


### Public API

Does the module introduce any public API? what services are introduced?

```bash
\Magento\Sales\Api\InvoiceOrderInterface
  * Create an Invoice
  * Change status and state
```

## Packagist Setting

- [Create account](https://packagist.org/register/)
- Connect with Github account
- [Submit package](https://packagist.org/packages/submit)
    - URL example: `https://github.com/rangerz/magento2-module-template`


### Tests

Includes a series of step-by-step examples for testing the module.


### Code Styles

Includes any relevant code style information or documentation.


### Configuration

Overview of the admin/configuration settings within the module.

| group | field | description |
|-------|-------|-------------|
|web    |default|example      |
|web    |default|example      |
|admin  |default|example      |


Support
-------

If you have any issues with this project, open an issue on [Github](https://github.com/iods/magento2-bones/issues)
=======
 * [Git](http://git-scm.com)
 * [PHP v8.1+](http://php.net)
 * [Magento CE 2.4+](http://magento.com)
 * [Composer](http://getcomposer.org)


Developer
---------

* **Rye Miller** - *Initial work* - [GitHub](http://github.com/iods/), [Homepage](https://ryemiller.io)

See also the list of [contributors](https://github.com/iods/magento2-performance/contributors) who participated in this project.


Versioning
----------

For transparency into the release cycle and in striving to maintain backward compatibility, this project is
maintained under [the Semantic Versioning guidelines](http://semver.org/).



Support
-------

If you have any issues with this module, open an issue on [Github](https://github.com/iods/magento2-base/issues)


Versioning
----------

For transparency into the release cycle and in striving to maintain backward compatibility, this project is
maintained under [the Semantic Versioning guidelines](http://semver.org/).


License
-------

This project/code is released under [the MIT license](https://github.com/iods/magento2-base/LICENSE).


Copyright
---------

(c) 2022 Rye Miller

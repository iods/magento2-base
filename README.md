<h1 align="center">Magento 2 Base Module</h1>

Base module container for extending and testing general functionality across Magento 2.


Facts
-----

 * Version: 0.1.1 (Development)
 * [Composer Package](https://packagist.org/packages/iods/module-base)
 * [Repository on Github](https://github.com/iods/magento2-base)


Description
-----------

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


Requirements
------------

 * [Git](http://git-scm.com)
 * [PHP v7.4+](http://php.net)
 * [Magento CE 2.3+](http://magento.com)
 * [Composer](http://getcomposer.org)


Developer
---------

**Rye Miller**

 * [GitHub](http://github.com/iods/)
 * [@ryemiller](https://twitter.com/ryemiller)


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

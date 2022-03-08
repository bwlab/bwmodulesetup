# Setup new prestashop module

This module was developed from Luifi Massa, owner of https://www.bwlab.it.

This module scaffolds new prestashop module with this simple command:

`bin/console bwlab:module:setup <module name> <name space>`

Example:
`bin/console bwlab:module:setup mytestmodule MyOrg\MyModuleName`

After scaffold you need:

- edit composer.json file
- exec `composer update`

This module generate a backend controller

This module scaffolds also the unit tests

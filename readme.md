## Testing instructions
1. Clone the repo via this url `git@github.com:vickris/Everli.git`
2. Install phpunit: `composer install`
3. Run tests while inside the root folder `./vendor/bin/phpunit`

*NOTE*: Tests will fail here. You need to update each of the php files inside the src folder to the classname for autoloading to work.

Example: Update `haversine_coverage.php` to `HaverSineCoverage.php`

Task files are inside `src` folder while test files are inside the `tests` folder.

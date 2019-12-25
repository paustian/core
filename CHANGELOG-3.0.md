# CHANGELOG - ZIKULA 3.0.x

## 3.0.0 (unreleased)

 - BC Breaks:
    - Minimum PHP version is now 7.2.0 instead of 5.5.9 (#3935).
    - Removed `Zikula\Core\Response\Ajax\*Response` classes (#3772). Use Symfony's `JsonResponse` with appropriate status codes instead.
    - Service definitions have been updated to use Symfony autowiring and autoconfiguring functionality (#3940, #3872). This includes autowiring entity repositories by inheriting from `ServiceEntityRepository`.
    - Removed second argument (`$first = true`) from `ZikulaHttpKernelInterface` methods `getModule`, `getTheme` and `isBundle` because bundle inheritance is not supported in Symfony 4 anymore (#3377).
    - Interface extensions and amendments
        - `Zikula\BlocksModule\Api\ApiInterface\BlockApiInterface` has dropped `getModuleBlockPath()` method.
        - `Zikula\BlocksModule\Api\ApiInterface\BlockFactoryApiInterface` has changed signature of `getInstance()` method.
        - `Zikula\Bundle\HookBundle\HookProviderInterface` requires a new method `getAreaName()` to be implemented.
        - `Zikula\Bundle\HookBundle\HookSubscriberInterface` requires a new method `getAreaName()` to be implemented.
        - `Zikula\Bundle\HookBundle\HookProviderInterface` has dropped `setServiceId` and `getServiceId` methods.
        - `Zikula\Bundle\HookBundle\Collector\HookCollectorInterface` has changed signature of `addProvider()` and `addSubscriber()` methods.
        - `Zikula\Common\Content\ContentTypeInterface` requires a new method `getBundleName()` to be implemented.
        - `Zikula\PermissionsModule\Entity\RepositoryInterface\PermissionRepositoryInterface` requires a new method `deleteGroupPermissions` to be implemented.
        - `Zikula\ŞearchModule\SearchableInterface` requires a new method `getBundleName()` to be implemented.
        - `Zikula\UsersModule\MessageModule\MessageModuleInterface` requires a new method `getBundleName()` to be implemented.
        - `Zikula\UsersModule\ProfileModule\ProfileModuleInterface` requires a new method `getBundleName()` to be implemented.
    - `Zikula\BlocksModule\AbstractBlockHandler` is not container aware anymore.
    - `Zikula\ExtensionsModule\Entity\ExtensionEntity` has renamed `core_min` to `coreCompatibility` and removed `core_max` property (#3649).
    - Removed all classes from the `Zikula\Core\Token` namespace. If you need custom CSRF tokens use [isCsrfTokenValid()](https://symfony.com/doc/current/security/csrf.html#generating-and-checking-csrf-tokens-manually) instead (#3206).
    - The `Zikula\Bundle\HookBundle\ServiceIdTrait` trait has been removed.
    - The `extra` field in `Zikula\SearchModule\Entity\SearchResultEntity` has changed from `text` to `array`. The `setExtra()` method takes care of that though.
    - Dropped vendors:
        - Removed afarkas/html5shiv
        - Removed afarkas/webshim (#3925)
        - Removed ramsey/array_column
        - Removed sensio/distribution-bundle (in favour of Flex)
        - Removed sensio/generator-bundle (in favour of symfony/maker-bundle)
        - Removed sensiolabs/security-checker
        - Removed symfony/polyfill-apcu
        - Removed symfony/polyfill-php56
        - Removed symfony/polyfill-php70
        - Removed symfony/polyfill-util
    - kriswallsmith/assetic downgraded from 1.4.0 to 1.0.5
    - The `polyfill` Twig tag has been removed (#3925).
    - Removed bootstrap-plus/bootstrap-jqueryui. Use jQuery UI directly.
    - Removed `ZikulaKernel::VERSION_SUB` constant.
    - Removed DoctrineCacheBundle use Symfony/Cache https://symfony.com/doc/current/components/cache.html
    - On upgrade, the startController setting is removed and requires resetting with new format FQCN::method

 - Deprecated:
    - As we are now using Twig 2 please use the namespaced Twig classes only (#3370).

 - Fixes:
    - Check if verification record is already deleted when confirming a changed mail address.
    - Updated listener priorities in Settings module to fix non-working variable localisation (#3934).
    - Fixed broken functionality of hiding submit button in search block.
    - Provide more kernel information in coredata (#3651).
    - Cosmetical corrections for account link graphics.
    - Properly consider "user must verify" flag during user creation in ZAuth module (#3964).
    - Removed workaround for older DBAL versions (#2185).
    - Properly handle deleted user groups in permissions module (#3963).
    - Made Blocks module's JavaScript functionality more robust (#3911).
    - Removed ancient workaround in printer theme (#3653).
    - Readded missing functionality for configurable page title schemes (#3921).
    - Readded missing permission checks for specific admin area categories.
    - Fixed behaviour of recent searches list.
    - Fixed admin notification email for new registrations which was not done in some cases.
    - Improved asset merger with regards to negative weights (#3978).
    - Fixed broken JavaScript in ZAuth user modification form (#3992).

 - Features:
    - Utilise autowiring and autoconfiguring functionality from Symfony (#1188).
    - Centralised dynamic form field handling from Profile module in FormExtensionsBundle (#3945).
    - Allow zasset syntax for relative assets also for normal bundles.
    - Added Twig function for creating a `RouteUrl` instance (#3802).
    - Added support for separators in dropdown menus of extensions interface / module links (#3904).
    - Added common header/footer templates for login templates (#3937).
    - Added common header/footer templates for user registration and login related email templates (#3937).
    - Reworked `Zikula\Bridge\HttpFoundation\DoctrineSessionHandler` to extend `Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler` (#3870).
    - Support arrays and longer strings in the `extra` field of search results (#3619, #3900).
    - More user-friendly response messages during account information recovery (#3723).
    - Scalar type hints have been added to all method arguments and return values; corresponding docblocks have been dropped (#3960).
    - Added Twig extensions for easy access to localised names of countries, currencies, languages, locales and timezones.

 - Vendor updates:
    - composer/ca-bundle updated from 1.2.4 to 1.2.5
    - composer/composer installed in 1.9.1
    - composer/spdx-licenses installed in 1.5.2
    - composer/xdebug-handler installed in 1.4.0
    - doctrine/annotations updated from 1.2.7 to 1.8.0
    - doctrine/collections updated from 1.3.0 to 1.6.4
    - doctrine/common updated from 2.6.2 to 2.11.0
    - doctrine/dbal updated from 2.5.13 to 2.10.0
    - doctrine/doctrine-bundle updated from 1.6.13 to 2.0.6
    - doctrine/event-manager installed in 1.1.0
    - doctrine/inflector updated from 1.1.0 to 1.3.1
    - doctrine/instantiator updated from 1.0.5 to 1.3.0
    - doctrine/lexer updated from 1.0.2 to 1.2.0
    - doctrine/orm updated from 2.5.14 to 2.7.0
    - doctrine/persistence installed in 1.3.3
    - doctrine/reflection installed in 1.0.0
    - egulias/email-validator installed in 2.1.12
    - friendsofsymfony/jsrouting-bundle updated from 1.6.3 to 2.5.1
    - gedmo/doctrine-extensions updated from 2.4.37 to 2.4.38
    - guzzlehttp/guzzle updated from 6.4.1 to 6.5.2
    - imagine/imagine updated from 0.7.1 to 1.3.3
    - jms/i18n-routing-bundle updated from 2.0.0 to 3.0.3
    - jms/translation-bundle updated from 1.3.2 to 1.4.4
    - jquery.mmenu updated from 7.3.3 to mmenu.js 8.4.4
    - justinrainbow/json-schema updated from 4.1.0 to 5.2.9
    - knplabs/knp-menu updated from 2.2.0 to 3.1.0
    - knplabs/knp-menu-bundle updated from 2.1.3 to 3.0.0
    - liip/imagine-bundle updated from 1.9.1 to 2.2.0
    - matthiasnoback/symfony-console-form updated from 2.3.0 to 3.6.0
    - michelf/php-markdown updated from 1.7.0 to 1.9.0
    - monolog/monolog updated from 1.25.2 to 1.25.3
    - nikic/php-parser updated from 1.4.1 to 4.3.0
    - paragonie/random_compat updated from 2.0.18 to 9.99.99
    - ralouphie/getallheaders updated from 2.0.5 to 3.0.3
    - seld/jsonlint installed in 1.7.2
    - seld/phar-utils installed in 1.0.1
    - stof/doctrine-extensions-bundle updated from 1.2.2 to 1.3.0
    - swiftmailer/swiftmailer updated from 5.4.12 to 6.2.3
    - symfony/contracts installed in 1.1.8
    - symfony/maker-bundle installed in 1.14.3
    - symfony/monolog-bundle updated from 3.2.0 to 3.4.0
    - symfony/phpunit-bridge updated from 3.4.14 to 4.4.2
    - symfony/polyfill-ctype updated from v1.12.0 to v1.13.1
    - symfony/polyfill-iconv installed in 1.13.1
    - symfony/polyfill-intl-icu updated from 1.11.0 to 1.13.1
    - symfony/polyfill-intl-idn updated from 1.11.0 to 1.13.1
    - symfony/polyfill-mbstring updated from v1.12.0 to v1.13.1
    - symfony/polyfill-php72 installed in 1.13.1
    - symfony/polyfill-php73 installed in 1.13.1
    - symfony/profiler-pack installed in 1.0.4
    - symfony/swiftmailer-bundle updated from 2.4.3 to 3.4.0
    - symfony/symfony updated from 3.4.35 to 4.4.2
    - twig/extensions updated from 1.4.1 to 1.5.4
    - twig/twig updated from 1.42.4 to 2.12.2
    - zikula/andreas08-theme updated from 3.0.2 to 3.1.1
    - zikula/generator-bundle updated from 2.0.1 to 3.0.1
    - zikula/legal-module updated from 3.1.2 to dev-master
    - zikula/oauth-module updated from 1.0.4 to dev-master
    - zikula/pagelock-module updated from 1.2.3 to dev-master
    - zikula/profile-module updated from 3.0.6 to dev-master
    - zikula/seabreeze-theme updated from 4.0.3 to dev-master
    - zikula/wizard updated from 2.0 to dev-master

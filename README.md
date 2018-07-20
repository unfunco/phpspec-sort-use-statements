# Sorted use statements for PhpSpec

## Requirements

* [PHP version 7.1+](https://secure.php.net)
* [PhpSpec version 4.0+](https://github.com/phpspec/phpspec)

## Installation and beyond

Using [Composer](https://getcomposer.org), require this package as a development dependency.

```bash
$ composer require --dev unfunco/phpspec-sort-use-statements
```

…and enable the extension by adding the following to your `phpspec.yml` configuration.

```yaml
extensions:
  Unfunco\PhpSpec\Extension\SortUseStatements: ~
```

## License

Copyright © 2018 [Daniel Morris](https://unfun.co)  
Made available under the terms of the [Apache License, Version 2.0].

[Apache License, Version 2.0]: LICENSE.md

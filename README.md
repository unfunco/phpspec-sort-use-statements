# Sorted use statements for PhpSpec

1. Are you working on a project with a namespace beginning with Q, R, S, T, U, V, W, X, Y, or Z?
2. Do you like your use statements sorted alphabetically?

If you answered yes to both of those questions, this is the PhpSpec extension for you!

## Requirements

* [PHP version 7.1+](https://secure.php.net)
* [PhpSpec version 4.0+](https://github.com/phpspec/phpspec)

## Installation and beyond

Using [Composer](https://getcomposer.org), require this package as a
development dependency:

```bash
$ composer require --dev unfunco/phpspec-sort-use-statements
```

…and enable the extension by adding the following to your `phpspec.yml`
configuration.

```yaml
extensions:
  Unfunco\PhpSpec\Extension\SortUseStatements: ~
```

Generate specifications as you normally would. If you are using a custom
specification template, you can add `%use%` to your template to interpolate
sorted `use` statements, as in this example:

```
<?php

namespace %namespace%;

%use%

final class %name% extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(%subject_class%::class);
    }
}
```

## License

Copyright © 2018 [Daniel Morris](https://unfun.co)  
Made available under the terms of the [Apache License, Version 2.0].

[Apache License, Version 2.0]: LICENSE.md

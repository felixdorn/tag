# Tag
![Packagist](https://img.shields.io/packagist/l/felixdorn/tag)
![Packagist Version](https://img.shields.io/packagist/v/felixdorn/tag)

## Getting started
You can install the package via composer, if you don't have composer, you can download it [here](https://getcomposer.org/):

```bash
composer require felixdorn/tag
```
Or by adding a requirement in your composer.json:
```json
{
    "require": {
        "felixdorn/tag": "^2.0.0"
    }
}
```

## Usage
```php
$tag = tag('div')
    ->class('container')
    ->children(
        tag('h1')->children('Title'),
        'Some raw content'
    );
```

### Adding attributes
We use the magic method `__call` to add attributes. You can add any attribute you want.

```php
tag('div')
    ->class('alert alert-danger')
    ->children('Something went wrong');
```

To add attributes containing a dash like `aria-hidden`, please use the equivalent in camel case (ariaHidden). We'll do the conversion back to kebab case when rendering the tag.

You can also assign multiple attributes at once.
```php
tag('div')
    ->attributes([
    'id' => 'my-div',
    'class' => 'mt-2'
]);
```

### Nested tags
```php
tag('div')
    ->class('container')
    ->children(
        tag('h1')->children('Some text')
    );

tag('div')
    ->children([
        tag('h1')->children(
            tag('span')->children('Hello'),
            tag('b')->children('World'),
        ),
        tag('br'),
        tag('h3')->children('Whatever')    
    ]);
```

## Credits
* [Félix Dorn](mailto:github@felixdorn.fr)

## License
This project is MIT Licensed.

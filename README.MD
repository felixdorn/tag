# Tag
![Packagist](https://img.shields.io/packagist/l/felixdorn/tag)
![Packagist Version](https://img.shields.io/packagist/v/felixdorn/tag)
[![Build Status](https://travis-ci.org/felixdorn/tag.svg?branch=master)](https://travis-ci.org/felixdorn/tag)
[![codecov](https://img.shields.io/codecov/c/github/felixdorn/tag)](https://codecov.io/gh/felixdorn/tag)

### Installation (with composer) 
`composer require felixdorn/tag`

### Getting started

#### Creating a tag
##### OOP
```php
$tag = TagFactory::create('div');
```
##### With a function
```php
$tag = tag('div');
```

#### Adding attributes
Tag use magic method `__call` to add attributes. In theory, you can add any attribute you want.
Only 50+ attributes are documented (in code) and could be auto-completed if your editor support `@method` tag in phpDoc.
```php
$tag
    ->class('alert alert-danger')
    ->text('Something went wrong');
```

#### Nested tags
Tag supports... nested tags. So you can do that :
```php
$tag
    ->class('container')
    ->text(
        tag('h1')->text('Some text')
    );

// Tags on the same line
$tag
    ->text([
        tag('h1')->text([
            tag('span')->text('Hello'),
            tag('b')->text('World'),
        ]),
        tag('br'),
        tag('h3')>text('Whatever')    
    ]);
```
#### Credits
* [Félix Dorn](mailto:github@felixdorn.fr)

#### License

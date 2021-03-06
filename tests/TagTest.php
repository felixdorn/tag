<?php

use Felix\Tag\Tag;

it('can create a tag', function () {
    $tag = tag('div');
    $tag->attribute('some', 'attribute');
    $tag->children('text');

    expect('<div some="attribute" >text</div>')->toLookLike($tag->toHtml());
});

it('can convert a tag to string', function () {
    $tag = tag('div');
    $tag->attribute('some', 'attribute');
    $tag->children('text');

    expect((string) $tag)->toLookLike('<div some="attribute">text</div>');
});

it('can set attributes using __call', function () {
    $tag = tag('whatever');
    $tag->some('value');

    expect($tag->toHtml())->toLookLike('<whatever some="value"></whatever>');
});

it('can recursively produce html', function () {
    $tag = tag('body')
        ->children([
            tag('div')
                ->class('jumbotron')
                ->children(
                    [
                        tag('h1')
                            ->class('display-3')
                            ->children('My super cool website'),
                        tag('input'),
                    ]),
        ]);

    expect($tag->toHtml())->toLookLike('<body><div class="jumbotron"><h1 class="display-3">My super cool website</h1><input /></div></body>');
});

test('attribute names are converted to pascal case', function () {
    $tag = tag('div')->ariaHidden('true');

    expect($tag->toHtml())->toLookLike('<div aria-hidden="true"></div>');
});

test('tag() function returns a tag')
    ->assertInstanceOf(Tag::class, tag('whatever'));

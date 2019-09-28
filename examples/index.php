<?php
/**
 * This file is part of Tag.
 *
 * Tag is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Tag is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tag.  If not, see <https://www.gnu.org/licenses/>.
 */


use Felix\Tag\TagFactory;

require '../vendor/autoload.php';

echo TagFactory::getDoctype();

$head = TagFactory::create('head')
    ->text([
        TagFactory::create('meta')->name('charset')->value('utf8'),
        TagFactory::create('title')->text('My cool app'),
        TagFactory::create('link')
            ->rel('stylesheet')
            ->href('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css')
    ]);

$body = TagFactory::create('body')
    ->text([
        tag('div')
            ->class('jumbotron')
            ->text(
                tag('h1')
                    ->class('display-3')
                    ->text('My super cool website')
            )
    ]);

echo TagFactory::create('html')->text([$head, $body]);

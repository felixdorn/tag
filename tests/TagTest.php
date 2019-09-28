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


namespace Felix\Tests\Tag;

use Felix\Tag\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testIsSelfClosingTag()
    {
        $selfClosingTags = [
            'area',
            'base',
            'br',
            'col',
            'embed',
            'hr',
            'img',
            'input',
            'link',
            'meta',
            'param',
            'source',
            'track',
            'wbr',
            'command',
            'keygen',
            'menuitem',
        ];

        $method = (new \ReflectionClass(Tag::class))
            ->getMethod('isSelfClosingTag');
        $method->setAccessible(true);
        foreach ($selfClosingTags as $selfClosingTag) {
            $this->assertTrue($method->invokeArgs(tag('whatever'), [$selfClosingTag]));
        }

        $this->assertFalse($method->invokeArgs(\tag('whatever'), ['div']));
    }

    public function testCreatingTag()
    {
        $tag = \tag('div');
        $tag->attribute('some', 'attribute');
        $tag->text('text');
        $output = $tag->getHtml();

        $this->assertEquals('<div some="attribute" >text</div>', $output);
    }

    public function testToString()
    {
        $tag = \tag('div');
        $tag->attribute('some', 'attribute');
        $tag->text('text');

        $output = $tag->__toString();

        $this->assertEquals('<div some="attribute" >text</div>', $output);
    }

    public function testCallMagicMethod()
    {
        $tag = \tag('whatever');

        $tag->some('value');

        $output = $tag->getHtml();

        $this->assertEquals('<whatever some="value" ></whatever>', $output);
    }

    public function testRecursivelyGetHtml()
    {

        $tag = tag('body')
            ->text([
                tag('div')
                    ->class('jumbotron')
                    ->text(
                    [
                        tag('h1')
                            ->class('display-3')
                            ->text('My super cool website'),
                        tag('input')
                    ])
            ]);

        $output = $tag->getHtml();

        $this->assertEquals("<body ><div class=\"jumbotron\" ><h1 class=\"display-3\" >My super cool website</h1><input  /></div></body>", $output);
    }
}
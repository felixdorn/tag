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
use Felix\Tag\TagFactory;
use PHPUnit\Framework\TestCase;

class TagFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(Tag::class, TagFactory::create('whatever'));
    }

    /**
     * @covers \Felix\Tag\TagFactory::getDoctype
     */
    public function testGetDoctype()
    {
        $this->assertEquals('<!DOCTYPE html>', TagFactory::getDoctype());
    }
}
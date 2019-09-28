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

namespace Felix\Tag;

/**
 * @method Tag placeholder(string $text) Add a placeholder to the tag
 * @method Tag value(string $text) Add a value attribute to the tag
 * @method Tag required() Add required attribute to the tag
 * @method Tag download() Add download attribute to the tag
 * @method Tag type(string $value) Add a type attribute to the tag
 * @method Tag src(string $value) Add a src attribute to the tag
 * @method Tag alt(string $value) Add an alt attribute to the tag
 * @method Tag href(string $value) Add an href attribute to the tag
 * @method Tag name(string $value) Add a name attribute to the tag
 * @method Tag id(string $value) Add a id attribute to the tag
 * @method Tag class(string $value) Add a class attribute to the tag
 * @method Tag style(string $value) Add a style attribute to the tag
 * @method Tag title(string $value) Add a title attribute to the tag
 * @method Tag width(string $value) Add a width attribute to the tag
 * @method Tag height(string $value) Add a height attribute to the tag
 * @method Tag content(string $value) Add a content attribute to the tag
 * @method Tag description(string $value) Add a description attribute to the tag
 * @method Tag http-equiv(string $value) Add a http-equiv attribute to the tag
 * @method Tag archive(string $value) Add a archive attribute to the tag
 * @method Tag srcset(string $value) Add a srcset attribute to the tag
 * @method Tag autofocus() Add a autofocus attribute to the tag
 * @method Tag step() Add a step attribute to the tag
 * @method Tag disabled() Add a disabled attribute to the tag
 * @method Tag multiple() Add a multiple attribute to the tag
 * @method Tag list(string $value) Add a list attribute to the tag
 * @method Tag target(string $value) Add a target attribute to the tag
 * @method Tag method(string $value) Add a method attribute to the tag
 * @method Tag sandbox(string $value) Add a sandbox attribute to the tag
 * @method Tag preload(string $value) Add a preload attribute to the tag
 * @method Tag hreflang(string $value) Add a hreflang attribute to the tag
 * @method Tag muted() Add a muted attribute to the tag
 * @method Tag tabindex(string $value) Add a muted attribute to the tag
 * @method Tag nowrap() Add a nowrap attribute to the tag
 * @method Tag checked() Add a checked attribute to the tag
 * @method Tag accesskey(string $value) Add a accesskey attribute to the tag
 * @method Tag rel(string $value) Add a rel attribute to the tag
 * @method Tag media(string $value) Add a media attribute to the tag
 * @method Tag start(string $value) Add a start attribute to the tag
 * @method Tag defer() Add a defer attribute to the tag
 * @method Tag async() Add a async attribute to the tag
 * @method Tag lang() Add a lang attribute to the tag
 * @method Tag size(string $size) Add a size attribute to the tag
 * @method Tag contenteditable() Add a contenteditable attribute to the tag
 * @method Tag integrity(string $value) Add a integrity attribute to the tag
 * @method Tag crossorigin(string $value) Add a crossorigin attribute to the tag
 */
class Tag
{
    /**
     * @var string
     */
    private $tag;
    /**
     * @var array
     */
    private $attributes;
    /**
     * @var array
     */
    private $selfClosingTags;
    /**
     * @var string
     */
    private $text;

    /**
     * Tag constructor.
     * @param string $tag
     */
    public function __construct(string $tag)
    {
        $this->tag = $tag;
        $this->attributes = [];
        $this->selfClosingTags = [
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
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getHtml();
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $attributes = $this->buildAttributes($this->attributes);
        $text = $this->buildText($this->text);

        return $this->buildTag($this->tag, $attributes, $text);
    }

    /**
     * @param array $attributes
     * @return string
     */
    private function buildAttributes(array $attributes)
    {
        if (empty($attributes)) return '';

        $buffer = '';

        foreach ($attributes as $name => $attribute) {
            $buffer .= sprintf('%s="%s" ', $name, $attribute ?? $name);
        }

        return $buffer;
    }

    /**
     * @param Tag|string $text
     * @return string
     */
    private function buildText($text)
    {
        $buffer = '';
        if (is_array($text)) {
            foreach ($text as $item) {
                $buffer .= $this->processText($item);
            }
            return $buffer;
        }

        return $this->processText($text);
    }

    private function processText($text)
    {
        if ($text instanceof Tag) {
            // Recursion here because processText is called in getHtml
            return $text->getHtml();
        }

        return $text;
    }

    /**
     * @param string $tag
     * @param string $attributes
     * @param string $text
     * @return string
     */
    private function buildTag(string $tag, string $attributes, $text = '')
    {
        if ($this->isSelfClosingTag($tag)) {
            return sprintf('<%s %s />', $tag, $attributes);
        }
        return sprintf('<%s %s>%s</%s>', $tag, $attributes, $text, $tag);
    }

    /**
     * @param string $tag
     * @return bool
     */
    private function isSelfClosingTag(string $tag)
    {
        return in_array($tag, $this->selfClosingTags);
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $argument = array_key_exists(0, $arguments) ? $arguments[0] : null;

        $this->attribute($name, $argument);

        return $this;
    }

    /**
     * @param string $name
     * @param string|null $value
     * @return $this
     */
    public function attribute(string $name, ?string $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param Tag[]|Tag|string $value
     * @return Tag
     */
    public function text($value)
    {
        $this->text = $value;

        return $this;
    }
}
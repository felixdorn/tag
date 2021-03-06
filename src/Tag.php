<?php

namespace Felix\Tag;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Traits\Macroable;

/**
 * @method Tag placeholder(string $text)  Add a placeholder to the tag
 * @method Tag required()                 Add required attribute to the tag
 * @method Tag download()                 Add download attribute to the tag
 * @method Tag type(string $value)        Add a type attribute to the tag
 * @method Tag src(string $value)         Add a src attribute to the tag
 * @method Tag alt(string $value)         Add an alt attribute to the tag
 * @method Tag href(string $value)        Add an href attribute to the tag
 * @method Tag name(string $value)        Add a name attribute to the tag
 * @method Tag id(string $value)          Add a id attribute to the tag
 * @method Tag class(string $value)       Add a class attribute to the tag
 * @method Tag style(string $value)       Add a style attribute to the tag
 * @method Tag title(string $value)       Add a title attribute to the tag
 * @method Tag width(string $value)       Add a width attribute to the tag
 * @method Tag height(string $value)      Add a height attribute to the tag
 * @method Tag content(string $value)     Add a content attribute to the tag
 * @method Tag description(string $value) Add a description attribute to the tag
 * @method Tag httpEquiv(string $value)   Add a http-equiv attribute to the tag
 * @method Tag archive(string $value)     Add a archive attribute to the tag
 * @method Tag srcset(string $value)      Add a srcset attribute to the tag
 * @method Tag autofocus()                Add a autofocus attribute to the tag
 * @method Tag step()                     Add a step attribute to the tag
 * @method Tag disabled()                 Add a disabled attribute to the tag
 * @method Tag multiple()                 Add a multiple attribute to the tag
 * @method Tag list(string $value)        Add a list attribute to the tag
 * @method Tag target(string $value)      Add a target attribute to the tag
 * @method Tag method(string $value)      Add a method attribute to the tag
 * @method Tag sandbox(string $value)     Add a sandbox attribute to the tag
 * @method Tag preload(string $value)     Add a preload attribute to the tag
 * @method Tag hreflang(string $value)    Add a hreflang attribute to the tag
 * @method Tag muted()                    Add a muted attribute to the tag
 * @method Tag tabindex(string $value)    Add a muted attribute to the tag
 * @method Tag nowrap()                   Add a nowrap attribute to the tag
 * @method Tag checked()                  Add a checked attribute to the tag
 * @method Tag accesskey(string $value)   Add a accesskey attribute to the tag
 * @method Tag rel(string $value)         Add a rel attribute to the tag
 * @method Tag media(string $value)       Add a media attribute to the tag
 * @method Tag start(string $value)       Add a start attribute to the tag
 * @method Tag defer()                    Add a defer attribute to the tag
 * @method Tag async()                    Add a async attribute to the tag
 * @method Tag lang()                     Add a lang attribute to the tag
 * @method Tag size(string $size)         Add a size attribute to the tag
 * @method Tag contenteditable()          Add a contenteditable attribute to the tag
 * @method Tag integrity(string $value)   Add a integrity attribute to the tag
 * @method Tag crossorigin(string $value) Add a crossorigin attribute to the tag
 * @method Tag charset(string $value)     Add a charset attribute to the tag
 */
class Tag implements Htmlable
{
    use Macroable;

    public const SELF_CLOSING_TAGS = [
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

    protected string $tag;

    /** @var array<string, string|null> */
    protected array $attributes = [];
    /** @var Tag[]|string[] */
    protected array $children = [];

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function __toString(): string
    {
        return $this->toHtml();
    }

    public function toHtml(): string
    {
        if (in_array($this->tag, static::SELF_CLOSING_TAGS)) {
            return sprintf(
                '<%s %s />',
                $this->tag,
                $this->buildAttributes($this->attributes)
            );
        }

        return sprintf(
            '<%s %s>%s</%s>',
            $this->tag,
            $this->buildAttributes($this->attributes),
            $this->buildChildren($this->children),
            $this->tag
        );
    }

    /**
     * @param array<string, string|null> $attributes
     */
    protected function buildAttributes(array $attributes): string
    {
        return array_reduce($attributes, function ($_, $attribute) use ($attributes) {
            $name = (string) array_search($attribute, $attributes);

            return $_ . ' ' . sprintf('%s="%s" ', $this->pascalCase($name), $attribute ?? $name);
        }, '');
    }

    protected function pascalCase(string $name): string
    {
        return strtolower(
        // If there's an error we still return the original attribute
            preg_replace('/([a-z0-9]|(?=[A-Z]))([A-Z])/', '$1-$2', $name) ?: $name
        );
    }

    /**
     * @param Tag[]|string[] $children
     */
    protected function buildChildren($children): string
    {
        return array_reduce($children, function ($_, $child) {
            return $_ . array_reduce(
                // We make sure it's an array because $child may contain itself and be without siblings
                    !is_array($child) ? [$child] : $child,
                    fn ($_, $sibling) => $_ . ($sibling instanceof self ? $sibling->toHtml() : $sibling), '');
        }, '');
    }

    /**
     * @param mixed[] $arguments
     *
     * @return $this
     */
    public function __call(string $name, array $arguments): self
    {
        $this->attribute($name, $arguments[0] ?? null);

        return $this;
    }

    public function attribute(string $name, ?string $value): Tag
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param array<string, string|null> $attributes
     *
     * @return $this
     */
    public function attributes(array $attributes = []): self
    {
        foreach ($attributes as $name => $value) {
            $this->attribute($name, $value);
        }

        return $this;
    }

    /**
     * @param Tag|string ...$value
     */
    public function children(...$value): Tag
    {
        $this->children = $value;

        return $this;
    }
}

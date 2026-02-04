<?php

namespace App\UI\Components;

class Button extends HtmlComponent
{
    private string $text;
    private string $style;

    public function __construct(string $text, string $style = 'btn-secondary', string $id = '')
    {
        parent::__construct($id ?: uniqid('btn_'));
        $this->text = $text;
        $this->style = $style;
    }

    public function render(): string
    {
        $attrs = $this->buildAttributesString($this->attributes);
        return "<button type='button' id='{$this->id}' class='btn {$this->style}' {$attrs}>{$this->text}</button>";
    }
}

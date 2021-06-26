<?php
namespace Eddy\Framework\Views;

interface Renderer
{
    /**
     * Render the given template as a string
     *
     * @param string $template
     * @param array $context
     *
     * @return string
     */
    public function render(string $template, array $context = []);
}

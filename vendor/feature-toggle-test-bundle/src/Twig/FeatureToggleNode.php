<?php

namespace Simformsolutions\FeatureToggleTestBundle\Twig;

use Twig\Compiler;
use Twig\Node\Node;

/**
 * Parses a feature tag
 */
class FeatureToggleNode extends Node
{
    protected $name;

    public function __construct($name, Node $feature, $lineno, $tag = null)
    {
        parent::__construct(array('feature' => $feature), array('name' => $name), $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        $globals = $compiler->getEnvironment()->getGlobals();
        $name    = $this->getAttribute('name');
        $enabled = (boolean)!isset($globals['_features'])
                    || !isset($globals['_features'][$name])
                    || $globals['_features'][$name] == true;

        // $compiler
        //     ->addDebugInfo($this)
        //     ->write(sprintf('if (!%b) {', $enabled))
        //     ->indent()
        //     ->write('<div class="feature disabled">')
        //     ->outdent()
        //     ->write('}')
        //     ->subcompile($this->getNode('feature'))
        //     ->write()
        //     ->indent()
        //     ->outdent();

        $compiler
            ->addDebugInfo($this)
            ->write(sprintf('if (!%b) {', $enabled))
            ->indent()
            ->write('<div class="feature disabled">')
            ->indent()
            ->subcompile($this->getNode('feature'))
            ->outdent()
            ->write('</div>')
            ->outdent()
            ->write('}');
    }
}

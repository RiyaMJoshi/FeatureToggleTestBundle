<?php

namespace Simformsolutions\FeatureToggleTestBundle\Twig;

use Simformsolutions\FeatureToggleTestBundle\Exception\FeatureToggleNotFoundException;
use Simformsolutions\FeatureToggleTestBundle\Feature\FeatureManager;
use Symfony\Bridge\Twig\ErrorRenderer\TwigErrorRenderer;
use Twig\Error\SyntaxError;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class FeatureToggleTokenParser extends AbstractTokenParser
{
    protected $manager;

    /**
     * @param FeatureManager $manager
     */
    public function __construct(FeatureManager $manager)
    {
        $this->manager = $manager;
    }


    public function parse(Token $token)
    {
        $name = null;

        $stream = $this->parser->getStream();
        while (!$stream->test(Token::BLOCK_END_TYPE)) {
            if ($stream->test(Token::STRING_TYPE)) {
                $name = $stream->next()->getValue();

                if (!$this->manager->has($name)) {
                    throw new FeatureToggleNotFoundException("The feature %s does not exist.", $name);
                } else {
                    $feature = $this->manager->get($name);
                }
            } else {
                $token = $stream->getCurrent();
                throw new SyntaxError(sprintf('Unexpected token "%s" of value "%s".', Token::typeToEnglish($token->getType()), $token->getValue()), $token->getLine()); 
            }
        }
        $stream->expect(Token::BLOCK_END_TYPE);

        // Store the body of the feature.
        $body = $this->parser->subparse(array($this, 'decideFeatureEnd'), true);

        $stream->expect(Token::BLOCK_END_TYPE);

        if ($feature->isEnabled()) {
            return $body;
        }
        
        return;
    }

    /**
     * Test whether the feature is ended or not.
     *
     * @param Token $token
     * @return bool
     */
    public function decideFeatureEnd(Token $token): bool
    {
        return $token->test($this->getEndTag());
    }

    /**
     * Return the tag that marks the beginning of a feature.
     *
     * @return string
     */
    public function getTag()
    {
        return 'feature';
    }

    /**
     * Return the tag that marks the end of the feature.
     *
     * @return string
     */
    public function getEndTag()
    {
        return 'end'.$this->getTag();
    }
}

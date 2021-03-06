<?php

/*
 * This file is part of JoliTypo - a project by JoliCode.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace JoliTypo\Bridge\Twig;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class JoliTypoExtension extends \Twig_Extension
{
    private $presets = [];

    public function __construct($presets)
    {
        $this->presets = $presets;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('jolitypo', [$this, 'translate']),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('jolitypo', [$this, 'translate'], ['pre_escape' => 'html', 'is_safe' => ['html']]),
        ];
    }

    public function translate($text, $preset = 'default')
    {
        if (!isset($this->presets[$preset])) {
            throw new InvalidConfigurationException(sprintf("There is no '%s' preset configured.", $preset));
        }

        return $this->presets[$preset]->fix($text);
    }

    public function getName()
    {
        return 'jolitypo';
    }
}

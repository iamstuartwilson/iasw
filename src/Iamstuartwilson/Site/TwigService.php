<?php

namespace Iamstuartwilson\Site;

use Twig_Autoloader;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Twig_SimpleFunction;

class TwigService
{
    const TEMPLATE_DIR = '/../../../templates';
    const CACHE_DIR = '/../../../cache';

    /**
     * @var class Twig
     */
    protected $twig;

    /**
     * @var boolean $cache
     */
    protected $enableCache = true;

    public function __construct($cache = true)
    {
        $this->enableCache = (bool) $cache;
    }

    /**
     * Returns a new twig instance
     *
     * @return Twig
     */
    public function get()
    {
        if ($this->twig) {
            return $this->twig;
        }

        Twig_Autoloader::register();

        $loader = new Twig_Loader_Filesystem(__DIR__ . self::TEMPLATE_DIR);
        $options = [
            'extName' => '.twig',
        ];

        // Set cache option for faster rendering
        if ($this->enableCache) {
            $options['cache'] = __DIR__ . self::CACHE_DIR;
        }

        // Create twig instance
        $this->twig = new Twig_Environment($loader, $options);

        // Date helper function
        $this->twig->addFunction(new Twig_SimpleFunction('date', function ($format) {
            return date($format);
        }));

        return $this->twig;
    }
}

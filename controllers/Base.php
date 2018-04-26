<?php

namespace controllers;

use resources\Config;

abstract class Base extends Controller
{
    /** @var  string */
    protected $title;

    /** @var  string */
    protected $content;

    /** @var  array */
    protected $styles;

    /** @var  array */
    protected $scripts;

    /** @var  string */
    protected $template;

    function __construct()
    {
        $this->setTemplate(Config::BASE_THEME);
        $this->setStyles(Config::STYLES);
        $this->setScripts(Config::SCRIPTS);
        $this->setContent('');
        $this->setTitle($_SERVER['SERVER_NAME']);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Base
     */
    public function setTitle($title): Base
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Base
     */
    public function setContent(string $content): Base
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return array
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * @param array $styles
     * @return Base
     */
    public function setStyles(array $styles): Base
    {
        $this->styles = $styles;
        return $this;
    }

    /**
     * @return array
     */
    public function getScripts(): array
    {
        return $this->scripts;
    }

    /**
     * @param array $scripts
     * @return Base
     */
    public function setScripts(array $scripts): Base
    {
        $this->scripts = $scripts;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return Base
     */
    public function setTemplate(string $template): Base
    {
        $this->template = $template;
        return $this;
    }

    public function render()
    {
        $meanings = [
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'styles' => $this->getStyles(),
            'scripts' => $this->getScripts()
        ];
        $page = $this->template($this->getTemplate(), $meanings);
        echo $page;
        die();
    }
}

<?php

namespace controllers;

use resources\Config;

abstract class Controller
{
    /** @var  array */
    protected $params;

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    protected abstract function render();

    /**
     * @param $action string
     * @param $params array
     */
    public function go(string $action, array $params)
    {
        $this->setParams($params);
        $this->$action();
        $this->render();
    }

    /**
     * Метод POST
     * @return bool
     */
    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * @param $fileName string Имя файла шаблона
     * @param $meanings array массив с данными, передаваемыми в шаблон
     * @return string
     */
    protected function template(string $fileName, array $meanings): string
    {
        foreach ($meanings as $key => $meaning) {
            $$key = $meaning;
        }
        ob_start();
        include Config::VIEW . "{$fileName}";
        return ob_get_clean();
    }
}

<?php

namespace resources;

use \controllers\Ajax;
use \controllers\Ticket;
use \controllers\Administrator;
use \controllers\Generator;
use \controllers\Index;
use \controllers\Controller;

class Route
{
    /** @var  Controller */
    protected $controller;

    /** @var  string */
    protected $action;

    /** @var  array*/
    protected $params;

    /**
     * Route constructor.
     * @param $url array
     */
    public function __construct(array $url)
    {
        $this->setParams($url);
        $this->checkController();
        $this->checkAction();
        $this->request();
    }

    /**
     * @param Controller $controller
     * @return Route
     */
    public function setController(Controller $controller): Route
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param $action
     * @return Route
     */
    public function setAction(string $action): Route
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param mixed $params
     * @return Route
     */
    public function setParams($params): Route
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function checkController()
    {
        switch ($this->getParamByKey(1)) {
            case 'ajax' :
                $this->setController(new Ajax);
                break;
            case 'buyTickets' :
                $this->setController(new Ticket);
                break;
            case 'administrator' :
                $this->setController(new Administrator);
                break;
            case 'generator' :
                $this->setController(new Generator);
                break;
            default:
                $this->setController(new Index);
        }
    }

    /**
     * @param $key int ключ массива
     * @return mixed
     */
    public function getParamByKey(int $key)
    {
        if (!isset($this->getParams()[$key])) {
            return null;
        }

        return $this->getParams()[$key];
    }

    public function checkAction()
    {
        $action = $this->getParamByKey(2) ?? 'index';
        $this->setAction(Config::PREFIX_ACTION . $action);
    }

    public function request()
    {
        $this->getController()->go($this->getAction(), $this->getParams());
    }
}
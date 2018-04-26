<?php

namespace resources;

class Url
{
    /** @var  string */
    protected $queryString;

    /** @var  array */
    protected $params;

    /**
     * Url constructor.
     * @param $get mixed
     */
    public function __construct($get)
    {
        $this->setQueryString($get);
        $this->checkParams();
    }

    /**
     * @return mixed
     */
    public function getQueryString()
    {
        return $this->queryString;
    }

    /**
     * @param  $queryString mixed
     * @return Url
     */
    public function setQueryString($queryString): Url
    {
        $this->queryString = $queryString;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return Url
     */
    public function setParams(array $params): Url
    {
        $this->params = $params;
        return $this;
    }

    public function checkParams()
    {
        $params = explode('/', $this->getQueryString());
        $lastIndex = count($params) - 1;
        if ($params[$lastIndex] == '') {
            unset($params[$lastIndex]);
        }
        $this->setParams($params);
    }
}
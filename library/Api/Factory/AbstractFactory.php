<?php


namespace Api\Factory;

abstract class AbstractFactory
{
    protected
        $container;

    public function get ($name)
    {
        return $this->{'build'.$name}();
    }

    public function accept ($container)
    {
        $this->container = $container;
    }
}

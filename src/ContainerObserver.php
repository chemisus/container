<?php

namespace Chemisus\Container;

interface ContainerObserver
{
    public function onStore($key, &$value);

    public function onDelete($key);
}
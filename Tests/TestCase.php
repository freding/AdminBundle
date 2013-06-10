<?php

namespace Fredb\AdminBundle\Tests;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;


class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function getContainer()
    {
        return new ContainerBuilder(new ParameterBag(array(
            'kernel.debug' => false,
        )));
    }
}

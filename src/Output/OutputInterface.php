<?php
declare(strict_types=1);

namespace RouteFinder\Output;

use RouteFinder\Route;

interface OutputInterface
{
    /**
     * @param Route $route
     *
     * @return mixed
     */
    public function output(Route $route);
}
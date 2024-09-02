<?php

declare(strict_types=1);

namespace HibouTech\Framework\Tests;


class DependencyClass {
  public function __construct(private SubDependencyClass $subDependency) {}

  public function getSubDependency(): SubDependencyClass
  {
    return $this->subDependency;
  }

}

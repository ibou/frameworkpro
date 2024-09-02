<?php


namespace HibouTech\Framework\Tests;


use HibouTech\Framework\Container\Container;
use HibouTech\Framework\Container\ContainerException;
use PHPUnit\Framework\Attributes\Test;


class ContainerTest extends \PHPUnit\Framework\TestCase
{

  #[Test]
  public function a_service_can_be_retrieved_from_the_container()
  {
    // Setup
    $container = new Container();

    // Do something
    // id string, concrete class name string | object
    $container->add('dependant-class', DependantClass::class);

    // Make assertions
    $this->assertInstanceOf(DependantClass::class, $container->get('dependant-class'));
  }

  #[Test]
  public function a_ContainerException_is_thrown_if_a_service_cannot_be_found()
  {
    // Setup
    $container = new Container();

    // Expect exception
    $this->expectException(ContainerException::class);

    // Do something
    $container->add('foobar');
  }

  #[Test]
  public function a_service_can_be_added_to_the_container_as_an_instance()
  {
    // Setup
    $container = new Container();

    // Do something
    $container->add('dependant-class', DependantClass::class);
    $this->assertTrue($container->has('dependant-class'));
    $this->assertFalse($container->has('dependant-class-2'));
  }

  #[Test]
  public function services_can_be_recursively_autowired()
  {
    $container = new Container();

    $dependantService = $container->get(DependantClass::class);

    $dependancyService = $dependantService->getDependency();

    $this->assertInstanceOf(DependencyClass::class, $dependancyService);
    $this->assertInstanceOf(SubDependencyClass::class, $dependancyService->getSubDependency());
  }
}

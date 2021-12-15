<?php

namespace App;

use Closure;

class Container
{

    protected $bindings = [];

    protected $singletons = [];

    public function bind($key, $concrete, $shared = false)
    {
        $this->bindings[$key] = [
            'concrete' => $concrete,
            'shared'   => $shared,
        ];
    }

    public function singleton($key, $concrete)
    {
        $this->bind($key, $concrete, true);
    }

    public function get($key)
    {
        if ( ! isset($this->bindings[$key])) {
            if (class_exists($key)) {
                return $this->build($key);
            }

            throw new \Exception("No binding was registered for {$key}");
        }

        $binding = $this->bindings[$key];

        if ($binding['shared'] && isset($this->singletons[$key])) {
            return $this->singletons[$key];
        }

        if ( ! $binding['concrete'] instanceof Closure) {
            return $binding['concrete'];
        }

        return tap($binding['concrete'](), function ($concrete) use ($binding, $key) {
            if ($binding['shared']) {
                $this->singletons[$key] = $concrete;
            }
        });

    }

    /**
     * @param string $key
     *
     * @return mixed|object
     * @throws \ReflectionException
     */
    protected function build(string $key)
    {
        $reflector   = new \ReflectionClass($key);
        $constructor = $reflector->getConstructor();

        if ( ! $constructor) {
            return new $key();
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $dependency     = $parameter->getType()->getName();
            $dependencies[] = $this->build($dependency);
        }

        return $reflector->newInstanceArgs($dependencies);
    }
}

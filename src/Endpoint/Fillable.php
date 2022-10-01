<?php

namespace ZarinPal\Sdk\Endpoint;

trait Fillable
{
    /**
     * @param array<string, string> $inputs
     */
    public function __construct(?array $inputs = null)
    {
        if ($inputs !== null){
            $this->fill($inputs);
        }
    }

    final public function __get(string $name):string
    {
        return $this->{$name};
    }

    final public function __set(string $name,string $value): void
    {
        $this->{$name} = $value;
    }

    final public function __isset(string $name): bool
    {
        return property_exists($this, $name);
    }

    /**
     * @param array<string, string> $inputs
     */
    final public function fill(array $inputs): self
    {
        foreach ($inputs as $key => $input) {
            if ($this->__isset($key)){
                $this->{$key} = $input;
            }
        }
        return $this;
    }
}
<?php

namespace Illuminate\Database\Eloquent\Factories;

trait HasFactory
{
    /**
     * Get a new factory instance for the model.
     *
     * @param  mixed  $parameters
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public static function factory(...$parameters)
    {
        $num = is_numeric($parameters[0] ?? null) ? $parameters[0] : null;
        $factory = static::newFactory();
        $builder = factory($factory ? $factory->modelName() : get_called_class(), $num);

        return $builder
            ->states(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        //
    }
}

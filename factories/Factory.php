<?php

namespace Illuminate\Database\Eloquent\Factories;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

abstract class Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model;

    /**
     * @var \Illuminate\Database\Eloquent\Factory
     */
    private $factory;
    private $currentState = '';

    /**
     * @var Faker
     */
    protected Faker $faker;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    abstract public function definition();

    public function __construct(\Illuminate\Database\Eloquent\Factory $factory, Faker $faker)
    {
        $this->factory = $factory;
        $this->faker = $faker;
    }

    public function configure()
    {

    }

    public static function initOld($factory)
    {
        $exclude = ['configure', 'definition', '__construct', 'modelName', 'initOld'];

        /** @var self $instance */
        $instance = app(static::class, ['factory' => $factory]);
        $instance->configure();
        $instance->factory->define($instance->modelName(), [$instance, 'definition']);

        $reflected = new \ReflectionClass($instance);
        foreach ($reflected->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if (in_array($method->name, $exclude)) {
                continue;
            }

            $instance->currentState = Str::snake($method->name, '-');
            $instance->{$method->name}();
        }
    }

    protected function state($callback) {
        $this->factory->state($this->modelName(), $this->currentState, $callback);
        return $this;
    }

    protected function afterMaking($callback) {
        $this->factory->afterMaking($this->modelName(), $callback, $this->currentState ?: 'default');
    }

    protected function afterCreating($callback) {
        $this->factory->afterCreating($this->modelName(), $callback, $this->currentState ?: 'default');
    }

    public function modelName()
    {
        return $this->model;
    }
}

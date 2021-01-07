<?php

namespace ThisIsDevelopment\LaravelFutureFactories;

use Symfony\Component\Finder\Finder;

class ModelFactory extends \Illuminate\Database\Eloquent\Factory
{
    public function load($path)
    {
        $declared = get_declared_classes();
        if (is_dir($path)) {
            foreach (Finder::create()->files()->name('*.php')->in($path) as $file) {
                require_once $file->getRealPath();
            }
        }

        $loaded = array_diff(get_declared_classes(), $declared);
        foreach ($loaded as $cls) {
            if (is_subclass_of($cls, \Illuminate\Database\Eloquent\Factories\Factory::class)) {
                $cls::initOld($this);
            }
        }

        return $this;
    }
}

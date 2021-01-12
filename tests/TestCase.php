<?php

namespace Tests;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class TestCase
 * @package Tests
 */
class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        Capsule::schema()->create('eloquent_stubs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();
        });

        Capsule::schema()->create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->timestamps();
        });
    }
}

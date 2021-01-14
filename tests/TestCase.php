<?php

namespace Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class TestCase
 * @package Tests
 */
class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
//        $this->withFactories(__DIR__.'/../database/factories');

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

        Schema::create('filter_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status_id');
            $table->timestamps();
        });

    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}

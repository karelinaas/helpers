<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeTable extends Migration
{
    /**
     * @return string
     */
    protected function table(): string
    {
        return (new \Tests\Unit\Type())->getTable();
    }

    public function up()
    {
        if (!Schema::hasTable($this->table())) {
            Schema::create($this->table(), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->unique();
                $table->string('title');
                $table->string('description')->nullable();
                $table->jsonb('meta')->nullable();
                $table->string('type');
                $table->bigInteger('value')->nullable();
                $table->integer('state_id')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table());
    }
}
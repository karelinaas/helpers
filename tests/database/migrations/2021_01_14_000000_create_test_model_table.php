<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpCraftsman\Models\Type;

class CreateTestModelTable extends Migration
{
    /**
     * @return string
     */
    protected function table(): string
    {
        return (new \Tests\database\Models\TestModel())->getTable();
    }

    public function up()
    {
        if (!Schema::hasTable($this->table())) {
            Schema::create($this->table(), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->unique();
                $table->unsignedInteger('status_id')->nullable();
                $table->unsignedInteger('type_id')->nullable();
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
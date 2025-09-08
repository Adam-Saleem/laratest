<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->text('address')->nullable();
            $table->string('job_title')->nullable();
            $table->string('status')->default('active');
            $table->string('phone_country_code')->nullable();
            $table->string('phone_number')->nullable();

            $table->text('properties')->nullable();

            $table->rememberToken();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();
        });

        (new \Corals\User\Communication\database\migrations\CreateNotificationTemplatesTable())->up();
        (new \Corals\User\Communication\database\migrations\CreateNotificationsTable())->up();

        Schema::create('social_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('provider_id');
            $table->string('provider');
            $table->string('token');
            $table->text('properties')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_accounts');
        Schema::dropIfExists('notification_templates');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('users');
    }
};

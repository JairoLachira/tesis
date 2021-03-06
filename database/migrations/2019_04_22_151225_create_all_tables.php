<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',200);
            $table->text('description')->nullable();
            $table->boolean('state')->default(1);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('description',100)->nullable();
            $table->boolean('state')->default(1);
            $table->timestamps();
        });
        Schema::create('categories_dishes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('description',100)->nullable();
            $table->timestamps();
        });

        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',200);
            $table->text('description')->nullable();
            $table->text('slogan')->nullable();
            $table->text('address');
            $table->integer('assessment');
            $table->string('telephone')->nullable();
            $table->integer('points');
            $table->text('image');
            $table->integer('user_id');
            $table->boolean('state')->default(1);
            $table->boolean('availability')->default(1);
            $table->integer('time')->default(10);
            $table->integer('capacity')->nullable();

            $table->timestamps();
        });

        Schema::create('requests_restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_restaurant',200);
            $table->string('district_name');
            $table->string('name_owner');
            $table->string('surname_owner');
            $table->string('email_owner');
            $table->string('telephone_owner');
            $table->boolean('state')->default(1);
            $table->timestamps();
        });

        Schema::table('restaurants', function ($table) {
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('category_id');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->integer('points')->default(0);
            $table->boolean('state')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function ($table) {
            $table->unsignedInteger('district_id');
            $table->foreign('district_id')->references('id')->on('districts');
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('asigned_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::table('asigned_roles', function ($table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->time('hour');
            $table->integer('n_people');
            $table->text('oca_special');
            $table->string('state');
            $table->decimal('total');
            $table->char('paid',2);
            $table->boolean('comision')->default(0);
            $table->timestamps();
        });

        Schema::table('orders', function ($table) {
            $table->unsignedInteger('restaurant_id');
            $table->unsignedInteger('user_id');
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('dishes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('price',20,2);
            $table->integer('time');
            $table->text('description')->nullable();
            $table->text('image');
            $table->boolean('state')->default(1);
            $table->timestamps();
        });

        Schema::table('dishes', function ($table) {
            $table->unsignedInteger('category_dish');
            $table->unsignedInteger('restaurant_id');
            $table->foreign('category_dish')->references('id')->on('categories_dishes');
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
        });

        Schema::create('details_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cant');
            $table->timestamps();
        });

        Schema::table('details_orders', function ($table) {
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('dish_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('dish_id')->references('id')->on('dishes');
        });

        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_card',255);
            $table->integer('cod_postal');
            $table->integer('month');
            $table->integer('year');
            $table->integer('cvc');
            $table->string('owner',200);
            $table->char('country');
            $table->timestamps();
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dia',50);
            $table->timestamps();
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->unsignedInteger('dish_id');
            $table->unsignedInteger('restaurant_id');
            $table->foreign('dish_id')->references('id')->on('dishes');
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
        });
        Schema::create('valorations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('restaurant_id');
            $table->decimal('score',4,2);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
        });

        Schema::create('adminstration_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',150);
            $table->integer('valor');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('districts');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('restaurants');
        Schema::dropIfExists('requests_restaurants');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('asigned_roles');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('details_orders');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('dishes');
        Schema::dropIfExists('cards');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('valorations');
        Schema::dropIfExists('adminstration_values');


    }
}

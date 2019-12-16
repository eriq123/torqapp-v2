<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      // department
    Schema::create('departments', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('department_name');
      $table->softDeletes(); 
    });

      // course
    Schema::create('courses', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('course_name');
      $table->unsignedBigInteger('department_id');

      $table->integer('supplies')->default('99999900');
      $table->integer('equipment')->default('99999900');
      $table->integer('supplemental')->default('99999900');

      $table->softDeletes(); 

      $table->foreign('department_id')
      ->references('id')
      ->on('departments')
      ->onDelete('cascade');
    });

      // users
    Schema::create('users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('course_id')->nullable();
      $table->unsignedBigInteger('department_id')->nullable();

      $table->string('title')->nullable();
      $table->string('first_name');
      $table->string('last_name');

      $table->string('username')->unique();
      $table->string('password');
      $table->string('active')->default('0');

      $table->string('profile_image')->nullable();
      $table->mediumText('signature')->nullable();
      $table->rememberToken();
      $table->timestamps();
      $table->softDeletes(); 

      $table->foreign('course_id')
      ->references('id')
      ->on('courses')
      ->onDelete('cascade');
      $table->foreign('department_id')
      ->references('id')
      ->on('departments')
      ->onDelete('cascade');
    });

      //ppmps
    Schema::create('ppmps', function (Blueprint $table) {
      $table->bigIncrements('id');
      // $table->integer('local_id'); // ppmp id for each user -- not a great idea because 
      // $table->string('reference_id'); // ppmp id for admin and for easy searching -- turns out it's just an id with format(dont need this)

      $table->unsignedBigInteger('user_id'); //for easy access ? but all ppmp details should be in this table for ARCHIVE
      $table->unsignedBigInteger('course_id'); //for auth user course 

      $table->string('status'); //ACTIVE == ongoing, APPROVED == by director, CLOSED == supplies received the items
      $table->string('course'); //for archive
      $table->longtext('prepared'); 
      $table->longtext('recommended')->nullable(); 
      $table->longtext('evaluated')->nullable(); 
      $table->longtext('approved')->nullable();
      $table->string('fiscal_year'); 
      $table->string('type');
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('user_id')
      ->references('id')
      ->on('users')
      ->onDelete('cascade');

      $table->foreign('course_id')
      ->references('id')
      ->on('courses')
      ->onDelete('cascade');
    });

      //apps
    Schema::create('apps', function (Blueprint $table) {
      $table->bigIncrements('id');

      $table->unsignedBigInteger('ppmp_id'); 
      $table->unsignedBigInteger('user_id'); 
      $table->unsignedBigInteger('course_id'); 

      $table->string('status'); 
      $table->string('course'); 

      $table->longtext('prepared')->nullable();  
      $table->longtext('recommended')->nullable(); 
      $table->longtext('approved')->nullable();

      $table->string('type'); 
      $table->string('fiscal_year'); 
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('ppmp_id')
      ->references('id')
      ->on('ppmps')
      ->onDelete('cascade');

      $table->foreign('user_id')
      ->references('id')
      ->on('users')
      ->onDelete('cascade');

      $table->foreign('course_id')
      ->references('id')
      ->on('courses')
      ->onDelete('cascade');
    });


      //request letter
    Schema::create('requests', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('user_id')->nullable(); 
      $table->unsignedBigInteger('app_id')->nullable(); 
      $table->longtext('section_head')->nullable();

      $table->string('date')->nullable();
      $table->longtext('content'); 

      $table->longtext('department_head')->nullable();
      $table->longtext('adaa')->nullable();
      $table->longtext('campus_director')->nullable();

      $table->string('attachment')->nullable(); 
      $table->string('status'); 
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('user_id')
      ->references('id')
      ->on('users')
      ->onDelete('cascade');

      $table->foreign('app_id')
      ->references('id')
      ->on('apps')
      ->onDelete('cascade');
      
    });

      //progress
    Schema::create('progress', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('request_id')->nullable(); 

      $table->string('status');
      $table->string('office')->nullable();
      
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('request_id')
      ->references('id')
      ->on('requests')
      ->onDelete('cascade');
      
    });

    
      //items
    Schema::create('items', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('ppmp_id')->nullable(); 
      $table->unsignedBigInteger('app_id')->nullable(); 

      // item details
      $table->string('code')->nullable()->default(' ');
      $table->string('category');
      $table->string('description');
      $table->integer('quantity');
      $table->string('unit');
      $table->integer('cost');
      $table->integer('total');
      $table->string('schedule');
      $table->string('comment')->nullable(); 
      $table->string('status'); 
      $table->boolean('requested'); 
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('ppmp_id')
      ->references('id')
      ->on('ppmps')
      ->onDelete('cascade');
      $table->foreign('app_id')
      ->references('id')
      ->on('apps')
      ->onDelete('cascade');
    });

      //request_items
    Schema::create('request_items', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('item_id'); 
      $table->unsignedBigInteger('request_id'); 

      $table->integer('quantity');
      $table->integer('total');
      $table->string('status'); 

      $table->timestamps();
      $table->softDeletes();

      $table->foreign('item_id')
      ->references('id')
      ->on('items')
      ->onDelete('cascade');
      $table->foreign('request_id')
      ->references('id')
      ->on('requests')
      ->onDelete('cascade');
    });

    // request_items_line
    Schema::create('request_items_line', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('request_items_id'); 

      $table->integer('quantity');
      $table->integer('cost');
      $table->integer('total');
      $table->timestamps();
      $table->softDeletes();

      $table->foreign('request_items_id')
      ->references('id')
      ->on('request_items')
      ->onDelete('cascade');
    });


  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('departments');
    Schema::dropIfExists('courses');
    Schema::dropIfExists('users');
    Schema::dropIfExists('ppmps');
    Schema::dropIfExists('apps');
    Schema::dropIfExists('items');
    Schema::dropIfExists('requests');
    Schema::dropIfExists('progress');
    Schema::dropIfExists('request_items');
    Schema::dropIfExists('request_items_line');

  }
}

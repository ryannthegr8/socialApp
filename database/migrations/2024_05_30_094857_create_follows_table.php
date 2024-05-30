<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            /** NOTE: When u use foreignId method, it creates both the column and the key, so what you write in its parameters matters for example in this case id un users table as 'user_id'
             * 2. But when foreign('') method is used, you create the column by yourself and add the references.
             * But essentially the two methods are just the same thing. it is just that the second method allows you to name your own column i.e 'followedUser' to avoid confusion
            */
            $table->id();
            // Stores follower id
            $table->foreignId('user_id');
            // Stores id of person followed
            $table->unsignedBigInteger('followedUser');
            $table->foreign('followedUser')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};

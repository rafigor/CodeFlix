<?php

use CodeFlix\Models\User;
use Illuminate\Database\Migrations\Migration;

class CreateUserAdminData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $model = User::create([
            'name' => env('ADMIN_DEFAULT_NAME','Administrator'),
            'email' => env('ADMIN_DEFAULT_EMAIL','admin@user.com'),
            'role' => User::ROLE_ADMIN,
            'password' => bcrypt(env('ADMIN_DEFAULT_PASSWORD','secret'))
        ]);
        $model->verified = true;
        $model->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $user = User::where('email','=',env('ADMIN_DEFAULT_EMAIL','admin@user.com'))->first();
        if ($user instanceof User){
            $user->delete();
        }

    }
}

<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Citizen::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'username' => $faker->sentence,
        'password' => bcrypt($faker->password),
        'email' => $faker->email,
        'phone' => $faker->sentence,
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Officer::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'username' => $faker->sentence,
        'password' => bcrypt($faker->password),
        'phone' => $faker->sentence,
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Report::class, static function (Faker\Generator $faker) {
    return [
        'report_time' => $faker->dateTime,
        'title' => $faker->sentence,
        'content' => $faker->text(),
        'picture_url' => $faker->sentence,
        'status' => $faker->sentence,
        'citizen_id' => $faker->sentence,
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Reply::class, static function (Faker\Generator $faker) {
    return [
        'reply_time' => $faker->dateTime,
        'content' => $faker->text(),
        'officer_id' => $faker->sentence,
        'report_id' => $faker->sentence,
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Citizen::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'username' => $faker->sentence,
        'password' => bcrypt($faker->password),
        'email' => $faker->email,
        'phone' => $faker->sentence,
        'remember_token' => null,
        'activated' => $faker->boolean(),
        'forbidden' => $faker->boolean(),
        'language' => $faker->sentence,
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});

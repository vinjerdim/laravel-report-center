<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'citizen' => [
        'title' => 'Citizens',

        'actions' => [
            'index' => 'Citizens',
            'create' => 'New Citizen',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'phone' => 'Phone',
            
        ],
    ],

    'officer' => [
        'title' => 'Officers',

        'actions' => [
            'index' => 'Officers',
            'create' => 'New Officer',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
            'phone' => 'Phone',
            
        ],
    ],

    'report' => [
        'title' => 'Reports',

        'actions' => [
            'index' => 'Reports',
            'create' => 'New Report',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'report_time' => 'Report time',
            'title' => 'Title',
            'content' => 'Content',
            'picture_url' => 'Picture url',
            'status' => 'Status',
            'citizen_id' => 'Citizen',
            
        ],
    ],

    'reply' => [
        'title' => 'Replies',

        'actions' => [
            'index' => 'Replies',
            'create' => 'New Reply',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'reply_time' => 'Reply time',
            'content' => 'Content',
            'officer_id' => 'Officer',
            'report_id' => 'Report',
            
        ],
    ],

    'citizen' => [
        'title' => 'Citizens',

        'actions' => [
            'index' => 'Citizens',
            'create' => 'New Citizen',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'phone' => 'Phone',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
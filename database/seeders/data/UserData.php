<?php 

namespace Database\Seeders\Data;


class UserData {

    public static $adminUsers = [
        [
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@mysbs.com',
        ]
    ];

    public static $gnUsers = [
        [
            'username' => 'alice',
            'first_name' => 'Alice',
            'last_name' => 'Blake',
            'email' => 'alice@mysbsdemo.com',
        ],
        [
            'username' => 'angela',
            'first_name' => 'Paul',
            'last_name' => 'Harris',
            'email' => 'paul@mysbsdemo.com',
        ],
        [
            'username' => 'angela',
            'first_name' => 'Angela',
            'last_name' => 'Thomas',
            'email' => 'angela@mysbsdemo.com',
        ]
    ];

    public static $snUsers = [
        [
            'username' => 'rachel',
            'first_name' => 'Rachel',
            'last_name' => 'Hill',
            'email' => 'rachel@mysbsdemo.com',
        ],
        [
            'username' => 'richard',
            'first_name' => 'Richard',
            'last_name' => 'Robinson',
            'email' => 'richard@mysbsdemo.com',
        ],
        [
            'username' => 'william',
            'first_name' => 'William',
            'last_name' => 'Jones',
            'email' => 'william@mysbsdemo.com',
        ]
    ];
}
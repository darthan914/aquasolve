<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar', 'login_count'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    

    public static function keypermission()
    {
        $array = 
        [
            // accessUser
            [
                'name' => 'User',
                'id' => 'user',
                'data' => 
                [
                    [
                        'name' => 'List',
                        'value' => 'list-user'
                    ],
                    [
                        'name' => 'Create',
                        'value' => 'create-user'
                    ],
                    [
                        'name' => 'Edit',
                        'value' => 'edit-user'
                    ],
                    [
                        'name' => 'Delete',
                        'value' => 'delete-user'
                    ],
                    [
                        'name' => 'Active',
                        'value' => 'active-user'
                    ],
                    [
                        'name' => 'Access',
                        'value' => 'access-user'
                    ],
                    [
                        'name' => 'Level',
                        'value' => 'level-user'
                    ],
                ]
            ],
            // accessInbox
            [
                'name' => 'Inbox',
                'id' => 'inbox',
                'data' => 
                [
                    [
                        'name' => 'List',
                        'value' => 'list-inbox'
                    ],
                    // [
                    //     'name' => 'Delete',
                    //     'value' => 'delete-inbox'
                    // ],
                ]
            ],
            // accessJobApply
            [
                'name' => 'Job Apply',
                'id' => 'jobApply',
                'data' => 
                [
                    [
                        'name' => 'List',
                        'value' => 'list-jobApply'
                    ],
                    // [
                    //     'name' => 'Delete',
                    //     'value' => 'delete-jobApply'
                    // ],
                ]
            ],
            // accessNews
            [
                'name' => 'News',
                'id' => 'news',
                'data' => 
                [
                    [
                        'name' => 'List',
                        'value' => 'list-news'
                    ],
                    [
                        'name' => 'Create',
                        'value' => 'create-news'
                    ],
                    [
                        'name' => 'Edit',
                        'value' => 'edit-news'
                    ],
                    [
                        'name' => 'Delete',
                        'value' => 'delete-news'
                    ],
                ]
            ],
            // accessPage
            [
                'name' => 'Page Management',
                'id' => 'page',
                'data' => 
                [
                    [
                        'name' => 'List',
                        'value' => 'list-page'
                    ],
                    [
                        'name' => 'Create',
                        'value' => 'create-page'
                    ],
                    [
                        'name' => 'Edit',
                        'value' => 'edit-page'
                    ],
                    [
                        'name' => 'Delete',
                        'value' => 'delete-page'
                    ],
                ]
            ],
        ];

        return $array;
    }

    
}

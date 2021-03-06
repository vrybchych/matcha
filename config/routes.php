<?php
    return [
        'notcount' => 'notification/count',
        'notifications' => 'notification/index',
        'checkupdate' => 'message/checkupdate',
        'addmessage' => 'message/addmessage',
        'message/([0-9]+)' => 'message/index/$1',
        'message' => 'message/index',
        'block' => 'block/block',
        'unblock' => 'block/unblock',
        'unlike' => 'like/unlike',
        'like' => 'like/like',
        'delete_search_tag/(.+)' => 'search/delete_search_tag/$1',
        'search' => 'search/index',
        'delete_tag/([0-9]+)' => 'profile/delete_tag/$1',
        'setlocation' => 'profile/set_location',
        'set_avatar/([0-9]+)' => 'profile/set_avatar/$1',
        'delete_photo/([0-9]+)' => 'profile/delete_photo/$1',
        'photo/([0-9]+)' => 'profile/photo/$1',
        'photos' => 'profile/photos',
        'edit_profile' => 'profile/edit',
        'profile/([0-9]+)' => 'profile/index/$1',
        'profile' => 'profile/index',
        'reset_password/([0-9]+)/([a-z0-9]+)' => 'user/reset_password/$1/$2',
        'forgot_password' => 'user/forgot_password',
        'sign_in' => 'user/sign_in',
        'sign_up' => 'user/sign_up',
        'logout' => 'user/logout',
        'auth/([0-9]+)/([a-z0-9]+)' => 'user/activate/$1/$2',
        '.+' => 'home/error',
        '' => 'home/index',
    ];
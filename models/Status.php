<?php

/**
 * 请求状态
 * @version 2017-08-24
 */
class Status
{
    public static $USERNAME_EMPTY = 1;

    public static $PASSWORD_EMPTY = 2;

    public static $USER_NOT_EXISTS = 3;

    public static $USER_REGISTER_FAILD = 4;

    public static $NOT_ALLOWED_METHOD = 403;

    public static $NOT_FOUND = 404;


    public static $DESC = [
        1 => 'username empty',
        2 => 'password empty',
        3 => 'user not exists',
        4 => 'user register failed',
        
        403 => 'forbbiden',
        404 => 'not found',
        401 => 'not auth',
        500 => 'server error',
    ];

}
<?php

require_once 'Status.php';

/**
 * 用户model
 * @version 2017-08-24
 */
class User
{
    /**
     * @var pdo 数据库
     */
    private $_db;

    /**
     * 用户构造函数
     * @param $db
     */
    public function __construct($db)
    {
        $this->_db = $db;
    }

    /**
     * 登录
     * @param $username
     * @param $password
     * @return mixed
     * @throws Exception
     */
    public function login($username, $password)
    {
        if (empty($username)) {
            throw new Exception('用户名不能为空', Status::$USERNAME_EMPTY);
        }
        if (empty($password)) {
            throw new Exception('密码不能为空', Status::$PASSWORD_EMPTY);
        }

        $sql = 'select 1 from t_users where username = :username and password =  :password';

        $smt = $this->_db->prepare($sql);
        $smt->bindParam(':username', $username);
        $smt->bindParam(':password', $password);

        $user = $smt->fetch(PDO::FETCH_ASSOC);
        if (empty($user)) {
            throw new Exception('用户名或密码错误', Status::$USER_NOT_EXISTS);
        } else {
            return $user;
        }
    }

    /**
     * 用户注册
     *
     * @param $username
     * @param $password
     * @return string 描述
     * @throws Exception
     */
    public function register($username, $password)
    {
        if (empty($username)) {
            throw new Exception('用户名不能为空', Status::$USERNAME_EMPTY);
        }
        if (empty($password)) {
            throw new Exception('密码不能为空', Status::$PASSWORD_EMPTY);
        }

        $sql = 'insert into users(username,password) values(:username,:password)';

        $smt = $this->_db->prepare($sql);
        $smt->bindParam(':username', $username);
        $smt->bindParam(':password', $password);

        if ($smt->execute()) {
            return $this->_db->lastInsertId();
        } else {
            throw new Exception("注册失败", Status::$USER_REGISTER_FAILD);
        }
    }
}
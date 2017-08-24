<?php

require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Status.php';

$pdo = require_once __DIR__ . '/lib/db.php';

class Rest
{
    /**
     * @var integer 资源id
     */
    private $res_id;

    /**
     * @var string 资源名称
     */
    private $res_name;

    /**
     * @var string 请求方法
     */
    private $method;

    /**
     * @var array 允许访问的资源
     */
    private $_allowed_res = ['users'];

    /**
     * @var array 允许的http方法
     */
    private $_allowed_method = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];


    /**
     * @var array body参数
     */
    private $_params;

    /**
     * @var user 用户对象
     */
    private $_user;


    /**
     * 构造函数，注入user
     *
     * @param $user
     */
    public function __construct($user)
    {
        $this->_user = $user;
    }


    /**
     * 执行入口
     */
    public function run()
    {
        try {
            $this->_initRequest();

            if ($this->res_name == 'users') {
                $this->_json($this->handUserRequest(), 200);
            } else {
                $this->_json($this->handOtherRequest(), 200);
            }
        } catch (Exception $e) {
            $this->_json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * URL解析，初始化资源参数
     */
    public function _initRequest()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        if (!in_array($this->method, $this->_allowed_method)) {
            throw new Exception('请求方式不被允许', Status::$NOT_ALLOWED_METHOD);
        }

        $url = $_SERVER['REQUEST_URI'];
        $arr = explode('/', $url);

        $this->res_name = $arr[1];
        if (!in_array($this->res_name, $this->_allowed_res)) {
            throw new Exception('资源找不到', Status::$NOT_FOUND);
        }

        if(!empty($arr[2])) {
            $this->res_id = $arr[2];
        }

        $this->_getBodyParams();
    }

    /**
     * 处理用户请求
     */
    public function handUserRequest()
    {
        switch ($this->method) {
            case 'GET':
                return $this->handUserLogin();
            case 'POST':
                return $this->handUserRegister();
        }
    }


    /**
     * 处理其他请求
     *
     */
    public function handOtherRequest()
    {
        return 1;
    }


    public function handUserLogin()
    {
        return 1;
    }

    /**
     * 处理用户注册
     * @return string 描述
     * @throws Exception
     */
    public function handUserRegister()
    {
        if (empty($this->_params['username'])) {
            throw new Exception("用户名不能为空", Status::$USERNAME_EMPTY);
        }
        if (empty($this->_params['password'])) {
            throw new Exception("密码不能为空", Status::$PASSWORD_EMPTY);
        }
        if ($this->method != 'POST') {
            throw new Exception("请求方法不允许", Status::$NOT_ALLOWED_METHOD);
        }

        return $this->_user->register($this->_params['username'], $this->_params['password']);
    }

    /**
     * 输出json结果
     */
    public function _json($data, $code)
    {
        if($code !=200 && $code != 204) {
            header("HTTP/1.1 $code " . Status::$DESC[$code]);
        }
        header("content-type:application/json;charset=utf-8");

        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取http body中的数据
     * @return mixed 描述
     */
    public function _getBodyParams()
    {
        $this->_params = (array)json_decode(file_get_contents('php://input'));
    }
}

$user = new User($pdo);
$rest = new Rest($user);
$rest->run();
<?php

class Request
{
    /**
     * リクエストメソッドがPOSTかどうか判定
     *
     * @return boolean
     */
    public function isPost()
    {
        // print_r($_SERVER['REQUEST_METHOD']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // echo 111;
            return true;
        }
        // echo 111;

        return false;
    }

    /**
     * GETパラメータを取得
     *
     * @param string $name
     * @param mixed $default 指定したキーが存在しない場合のデフォルト値
     * @return mixed
     */
    public function getGet($name, $default = null)
    {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }

        return $default;
    }

    /**
     * POSTパラメータを取得
     *
     * @param string $name
     * @param mixed $default 指定したキーが存在しない場合のデフォルト値
     * @return mixed
     */
    public function getPost($name, $default = null)
    {
        // echo 111;
        // print_r($name);
        // var_dump(isset($_POST[$name]));
        if (isset($_POST[$name])) {
            // echo 111;
            return $_POST[$name];
        }

        // echo 222;
        return $default;
    }

    /**
     * ホスト名を取得
     *
     * @return string
     */
    public function getHost()
    {
        if (!empty($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }
        
        return $_SERVER['SERVER_NAME'];
    }

    /**
     * SSLでアクセスされたかどうか判定
     *
     * @return boolean
     */
    public function isSsl()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            return true;
        }
        return false;
    }

    /**
     * リクエストURIを取得。リクエストされたURLの情報が$_SERVER['REQUEST_URI']に格納されている。
     *
     * @return string
     */
    public function getRequestUri()
    {
        // var_dump($_SERVER['REQUEST_URI']);  //  /task/web/
        return $_SERVER['REQUEST_URI'];  //ページにアクセスする際に指定されたURI（ドメイン以下のパス）末尾に / が付いているのは実際には一番後ろにフロントコントローラー(index.php)があるため？
    }

    /**
     * ベースURLを取得。PPHP221p。http://example.com/foo/bar/index.php/list index.php(フロントコントローラー)よりも前。ドメイン(~.com)よりも後ろ
     *
     * @return string
     */
    public function getBaseUrl()
    {
        $script_name = $_SERVER['SCRIPT_NAME'];  //現在実行されているスクリプトのパス  
        // print_r($script_name. PHP_EOL);  //  /task/web/index.php
        $request_uri = $this->getRequestUri();
        // var_dump($request_uri);
        // var_dump(dirname($script_name));
        if (0 === strpos($request_uri, $script_name)) {
            return $script_name;
        } else if (0 === strpos($request_uri, dirname($script_name))) {
            // var_dump(rtrim(dirname($script_name), '/'));
            return rtrim(dirname($script_name), '/');
        }

        return '';
    }

    /**
     * PATH_INFOを取得
     *
     * @return string
     */
    public function getPathInfo()
    {
        $base_url = $this->getBaseUrl();
        // print_r($base_url);
        $request_uri = $this->getRequestUri();
        // print_r($request_uri);

        // var_dump($pos = strpos($request_uri, '?'));
        if (false !== ($pos = strpos($request_uri, '?'))) {
            // echo 111;
            $request_uri = substr($request_uri, 0, $pos);
            // var_dump($request_uri);
        }

        // echo 111;
        // var_dump(strlen($base_url));
        // var_dump(strlen($request_uri));

        $path_info = (string)substr($request_uri, strlen($base_url));  //
        // print_r($path_info);

        return $path_info;
    }

    // 一つ前のページのurlを取得
    function getReferer()
    {
        $id = $_SERVER['HTTP_REFERER'];

        return $id;
    }
}

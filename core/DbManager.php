<?php

class DbManager
{
    protected $connections = [];
    protected $repository_connection_map = [];
    protected $repositories = [];

    /**
     * データベースへ接続
     *
     * @param string $name
     * @param array $params
     */
    public function connect($name, $params)
    {
        $params = array_merge([
            'dsn'      => null,
            'user'     => '',
            'password' => '',
            'options'  => [],
        ], $params);
        $con = new PDO(
            $params['dsn'],
            $params['user'],
            $params['password'],
            $params['options']
        );
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connections[$name] = $con;
    }

    /**
     * コネクションを取得。connect() メソッドで接続したコネクションを取得する。名前 の指定がされなかった場合、current() 関数を利用して取得するようにしています。current() 関数 は配列の内部ポインタが示す値を取得する関数です。ここでは配列の先頭の値を取得します。つまり、指定がなければ最初に作成した PDO クラスのインスタンスを返すようになっています。
     *
     * @string $name  nullがはいる
     * @return PDO
     */
    public function getConnection($name = null)
    {
        if (is_null($name)) {
            // echo 111;  こっちになる
            return current($this->connections);
        }

        // echo 222;
        return $this->connections[$name];
    }

    /**
     * リポジトリごとのコネクション情報を設定。実装しただけで使用されていない？
     *
     * @param string $repository_name
     * @param string $name
     */
    public function setRepositoryConnectionMap($repository_name, $name)
    {
        $this->repository_connection_map[$repository_name] = $name;
    }

    /**
     * 指定されたリポジトリに対応するコネクションを取得
     *
     * @param string $repository_name 引数はPost
     * @return PDO
     */
    public function getConnectionForRepository($repository_name)
    {
        // print_r($this->repository_connection_map[$repository_name]);

        if (isset($this->repository_connection_map[$repository_name])) {
            $name = $this->repository_connection_map[$repository_name];
            $con = $this->getConnection($name);
            // echo 111;
        } else {
            $con = $this->getConnection();
            // echo 222;  こっちになる 
        }

        return $con;
    }

    /**
     * リポジトリを取得
     *
     * @param string $repository_name  引数はPost
     * @return DbRepository PostRepositoryを返す
     */
    public function get($repository_name)
    {
        if (!isset($this->repositories[$repository_name])) {
            $repository_class = $repository_name . 'Repository';
            $con = $this->getConnectionForRepository($repository_name);

            $repository = new $repository_class($con);

            $this->repositories[$repository_name] = $repository;
        }

        return $this->repositories[$repository_name];
    }

    /**
     * デストラクタ
     * リポジトリと接続を破棄する
     */
    public function __destruct()
    {
        foreach ($this->repositories as $repository) {
            unset($repository);
        }

        foreach ($this->connections as $con) {
            unset($con);
        }
    }
}

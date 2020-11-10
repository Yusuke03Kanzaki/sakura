<?php

/*  DbRepository クラスはデータベースへのアクセスを行うクラスで、テーブルごとに DbRepository クラスの子クラスを作成するようにします。
各 Repository クラスには、たとえば user テーブルであれば UserRepository クラスを定義し、user テーブルへレコードの新規作成を行う insert() メソッドや id というカラムを元にデータを取得する fetchById() メソッドなどを必要に合わせて作成していくことを想定しています。
それぞれのメソッドの内部では SQL を実行することになりますが、SQL の実行時に頻繁に出てく るような処理を DbRepository に抽象化しておきます。
*/

abstract class DbRepository
{
    protected $con;

    /**
     * コンストラクタ
     *
     * @param PDO $con
     */
    public function __construct($con)
    {
        $this->setConnection($con);
    }

    /**
     * コネクションを設定
     *
     * @param PDO $con
     */
    public function setConnection($con)
    {
        $this->con = $con;
    }

    /**
     * クエリを実行。DbRepositoryクラスのexecute()メソッドでは前述のプリペアドステートメントを実行し、 PDOStatement クラスのインスタンスを取得します。一連の流れを毎回呼び出すのは少々面倒なの で、1 つのメソッドで実行できるようにします。
     *
     * @param string $sql
     * @param array $params
     * @return PDOStatement $stmt
     */
    public function execute($sql, $params = [])
    {
        // echo 444;
        $stmt = $this->con->prepare($sql);
        // echo 555;
        // print_r($stmt);
        // print_r($params);
        // print_r($stmt->execute($params));
        $stmt->execute($params);
        // echo 666;
        // print_r($stmt);

        return $stmt;
    }

    /**
     * クエリを実行し、結果を1行取得
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetch($sql, $params = [])
    {
        // print_r($sql);
        // print_r($params);
        // print_r($this->execute($sql, $params));
        // var_dump($this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC));
        // return $this->execute($sql, $params);
        return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    // function execute($sql, $params = [])
    // {
    //     return $this->execute($sql, $params);
    // }


    /**
     * クエリを実行し、結果をすべて取得
     *
     * @param string $sql
     * @param array $params
     * @return array
     * executeにsql文が入る
     */
    public function fetchAll($sql, $params = [])
    {
        // echo 111;
        // print_r($sql);
        // print_r($params);
        // var_dump($this->execute($sql, $params));
        // print_r($this->execute($sql, $params));
        // print_r($this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC));
        return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}

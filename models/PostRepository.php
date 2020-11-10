<?php

class PostRepository extends DbRepository
{

    //  レコードの新規作成を行う
    public function insert($user_name, $post_title, $post_subtitle, $body)  
    {
        $now = new DateTime();

        $sql = "
            INSERT INTO post(user_name, post_title, post_subtitle, body, created_at)
                VALUES(:user_name, :post_title, :post_subtitle, :body, :created_at)   
        "; 

        $stmt = $this->execute($sql, array(
            ':user_name'      => $user_name,
            ':post_title'     => $post_title,
            ':post_subtitle'  => $post_subtitle,
            ':body'           => $body,
            ':created_at'     => $now->format('Y-m-d H:i:s'),
        ));
    }

    // 投稿内容の変更
    function change($body, $id)
    {
        $sql = "
            UPDATE post 
            SET body = '$body'
            WHERE id = $id
        ";
        // echo $sql;

        return $this->execute($sql, array());
    }

    // 投稿を削除
    function deletion($id)
    {
        $sql = "
            DELETE
                FROM post
                WHERE id = $id
        ";

        return $this->execute($sql, array());
    }

    // 画像の登録を行う
    function imageinsert($imgdat)
    {
        $now = new DateTime();

        $sql = "
            INSERT INTO image(image, created_at) 
                VALUES(:imgdat, :created_at)
        ";

        $stmt = $this->execute($sql, array(
            ':imgdat' => $imgdat,
            ':created_at' => $now->format('Y-m-d H:i:s'),
        ));
        // echo 444;
    }

    //ユーザの投稿一覧ではユーザ ID からデータを取得する
    public function fetchAllByUserId($user_id)
    {
        $sql = "
            SELECT user_name
                FROM post
                ORDER BY created_at DESC
        ";

        return $this->fetchAll($sql, array(':user_id' => $user_id));
    }

    public function fetchByUserName($user_name)
    {
        $sql = "
            SELECT * 
                FROM user 
                WHERE user_name = :user_name";

        return $this->fetch($sql, array(':user_name' => $user_name));
    }

    //投稿を新しい順で取得。自作メソッド
    public function fetchAllPersonalArchivesByUserId()  
    {
        $sql = "
            SELECT *
            FROM post
                ORDER BY created_at DESC
        ";

        return $this->fetchAll($sql, array());
    }

    function fetchByIdAndUserName()
    {
        // echo 222;
        $sql = "
            SELECT *
                FROM post
        ";

        return $this->fetch($sql, array(/*
            ':id'        => $id,
            ':user_name' => $user_name,
        */));
    }

    // 画像を取得 
    function fetchImage()
    {
        $sql = "
            SELECT image
                FROM image
                ORDER BY created_at DESC
        ";

        return $this->fetchAll($sql, array());
    }

    // 投稿を編集
    function editing()
    {
        $sql = "
            SELECT body
                FROM post
        ";
        
        return $this->fetch($sql, array());
    }
}

    
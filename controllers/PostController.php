<?php

class PostController extends Controller
{

    // 一覧表示。とトップページ表示
    function indexAction()
    {
        $statuses = $this->db_manager->get('Post')
            ->fetchAllPersonalArchivesByUserId();

        print_r($statuses);
        // var_dump($statuses);
         return $this->render(array(
             'statuses'  => $statuses,
         ));
    }

     //詳細表示
    function showAction()
    {
        // print_r(111);
        $status = $this->db_manager->get('Post')
            ->fetchByIdAndUserName();
 
        // echo 222;
        // print_r($status);
        // var_dump($status);
        if (!$status) {
            $this->forward404();
        }
        // echo 333;
 
        return $this->render(array('status' => $status));
    }

    function aboutAction()
    {
        // echo 111;
        $statuses = $this->db_manager->get('Status');
            // ->fetchAllPersonalArchivesByUserId($user['id']);  //エラーが出てheaderが消えてしまう

        return $this->render(array(
            'statuses' => $statuses,
            'body'     => '',
            '_token'   => $this->generateCsrfToken('status/post'),
        ));
    }

    function sampleAction()
    {
        // $user = $this->session->get('user');
        $statuses = $this->db_manager->get('Status');
            // ->fetchAllPersonalArchivesByUserId($user['id']);  //エラーが出てheaderが消えてしまう

        return $this->render(array(
            'statuses' => $statuses,
            'body'     => '',
            '_token'   => $this->generateCsrfToken('status/post'),
        ));
    }

    function contactAction()
    {
        // $user = $this->session->get('user');
        $statuses = $this->db_manager->get('Status');
            // ->fetchAllPersonalArchivesByUserId($user['id']);  //エラーが出てheaderが消えてしまう

        return $this->render(array(
            'statuses' => $statuses,
            'body'     => '',
            '_token'   => $this->generateCsrfToken('status/post'),
        ));
    }

    function post_indexAction()
    {
        // $user = $this->session->get('user');
        $statuses = $this->db_manager->get('Status');
            // ->fetchAllPersonalArchivesByUserId($user['id']);  //エラーが出てheaderが消えてしまう

        return $this->render(array(
            'statuses' => $statuses,
            'body'     => '',
            '_token'   => $this->generateCsrfToken('status/post'),
        ));
    }

    function postAction()
    {
        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $user_name = $this->request->getPost('name');
        $post_title = $this->request->getPost('post_title');
        $post_subtitle = $this->request->getPost('post_subtitle');
        $body = $this->request->getPost('body');
        // var_dump($user_name);

        $errors = array();

        //  保存処理です。セッションからユーザ情報を取得し、ユーザの id と投稿された データを PostRepository クラスの insert() メソッドに渡して保存しています。
        $this->db_manager->get('Post')->insert($user_name, $post_title, $post_subtitle, $body);

        return $this->render(array(
            'errors'   => $errors,
            'body'     => $body,
            // 'statuses' => $statuses,
            '_token'   => $this->generateCsrfToken('post/post'),
        )/*, 'index'*/);
    }

    //　画像投稿 表示
    function uploadAction()
    {
        // echo 111;
        // var_dump($this->request->isPost());
        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $upfile = $_FILES["upload"]["tmp_name"];
        if ($upfile==""){
            print("ファイルのアップロードができませんでした。<BR>");
            exit;
        }

        // ファイル取得
        $imgdat = file_get_contents($upfile);
        // var_dump($imgdat);
        // echo 333;

        //  保存処理です。セッションからユーザ情報を取得し、ユーザの id と投稿された データを PostRepository クラスの insert() メソッドに渡して保存しています。
        $this->db_manager->get('Post')->imageinsert($imgdat);

        // echo 111;
        // 画像データ取得
        $img = $this->db_manager->get('Post')->fetchImage();
        $image = $img[0]['image'];
        // var_dump($image);
        // $images = htmlspecialchars($image);
        $images = base64_encode($image);
        // print_r($images);

        // echo '<img src="$images">';

        // var_dump($image);
        // $result = mysql_query($sql, $dbLink);
        // $row = mysql_fetch_row($result);
        // echo 111;

        return $this->render(array(
            'images' => $images,
        ));
    }

    //画像一覧表示
    function imageAction()
    {
        $statuses = $this->db_manager->get('Post')->fetchImage();
        // $image = $this->db_manager->get('Post')->fetchImage();

        // $statuses = base64_encode($image['image']);
        // print_r($statuses);
        // var_dump($statuses);
        // var_dump($images);
        return $this->render(array(
            'statuses'  => $statuses,
        ));
    }

    //　文章の編集
    function editingAction()
    {
        $status = $this->db_manager->get('Post')
            ->editing();
        
        $id = $this->request->getReferer();

        $count = strrpos($id, '/');
    
        $id = substr($id, $count + 1);
        // print_r($id);
        // session_destroy();

        $_SESSION['id'] = $id;
        // print_r($_SESSION);

        // $this->storageAction($id);
        
        return $this->render(array(
            'statuses'  => $status,
            'id' => $id,
        ));
    }

    // 文章書き換え
    function changeAction()
    {
        if (!$this->request->isPost()) {
            $this->forward404();
        }
        session_start();
        $id = $_SESSION['id'];

        $body = $this->request->getPost('body');

        $errors = array();

        //  保存処理です。セッションからユーザ情報を取得し、ユーザの id と投稿された データを PostRepository クラスの insert() メソッドに渡して保存しています。
        $this->db_manager->get('Post')->change($body, $id);

        return $this->render(array(
      
        ));
    }

    // 削除
    function deletionAction()
    {
        $statuses = $this->db_manager->get('Status');

        $id = $this->request->getReferer();

        $count = strrpos($id, '/');

        $id = substr($id, $count + 1);

        $this->db_manager->get('Post')->deletion($id);

        // return $this->render(array(
        // ));

        return $this->render(array(
            'statuses'  => $statuses,
        ));
    }
}
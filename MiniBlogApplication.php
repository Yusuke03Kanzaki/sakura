<?php

class MiniBlogApplication extends Application
{
    protected $login_action = array('account', 'signin');

    public function getRootDir()
    {
        return dirname(__FILE__);
    }

    protected function registerRoutes()
    {
        return array(
            '/post/image'
                =>array('controller' => 'post', 'action' => 'image'),
            '/post/upload'
                =>array('controller' => 'post', 'action' => 'upload'),
            '/post/editing'
                =>array('controller' => 'post', 'action' => 'editing'),
            '/post/deletion'
                =>array('controller' => 'post', 'action' => 'deletion'),
            '/post/change'
                =>array('controller' => 'post', 'action' => 'change'),
            '/'
                =>array('controller' => 'post', 'action' => 'index'),
            '/post/about'
                =>array('controller' => 'post', 'action' => 'about'),
            '/post/sample'
                =>array('controller' => 'post', 'action' => 'sample'),
            '/post/contact'
                =>array('controller' => 'post', 'action' => 'contact'),
            '/post/post_index'
                =>array('controller' => 'post', 'action' => 'post_index'),
            '/post/post'
                =>array('controller' => 'post', 'action' => 'post'),
            '/post/:user_name'
                =>array('controller' => 'post', 'action' => 'status'), 
            '/post/:user_name/status/:id'
                =>array('controller' => 'post', 'action' => 'show'),
        );
    }

    protected function configure()
    {
        $this->db_manager->connect('master', array(
            'dsn'      => 'mysql:dbname=Task;host=127.0.0.1;charset=utf8',
            'user'     => 'root',
            'password' => 'N@5d7R^hmLD^',
        ));
    }
}

<?php

abstract class Controller
{
    protected $controller_name;
    protected $action_name;
    protected $application;
    protected $request;
    protected $response;
    protected $session;
    protected $db_manager;
    protected $auth_actions = array();

    /**
     * コンストラクタ
     *
     * @param Application $application
     */
    public function __construct($application)
    {
        // var_dump($application);
        // var_dump(get_class($this));
        $this->controller_name = strtolower(substr(get_class($this), 0, -10));
        // var_dump($this->controller_name);

        $this->application = $application;
        $this->request     = $application->getRequest();
        $this->response    = $application->getResponse();
        $this->session     = $application->getSession();
        $this->db_manager  = $application->getDbManager();
    }

    /**
     * アクションを実行
     *
     * @param string $action
     * @param array $params
     * @return string レスポンスとして返すコンテンツ
     *
     * @throws UnauthorizedActionException 認証が必須なアクションに認証前にアクセスした場合
     */
    public function run($action, $params = array())
    {
        // var_dump($action);
        $this->action_name = $action;

        $action_method = $action . 'Action';
        // print_r($action_method);
        // var_dump('Forwarded 404 page from '
        if (!method_exists($this, $action_method)) {
            // echo 111;

            $this->forward404();
        }

        if ($this->needsAuthentication($action) && !$this->session->isAuthenticated()) {
            throw new UnauthorizedActionException();
        }

        $content = $this->$action_method($params);

        return $content;
    }

    /**
     * ビューファイルのレンダリング。View クラスにはファイルの読み込みや変数の受け渡しなどを行いますが、柔軟性を持たせるため に多くの情報は View クラスを利用する側から指定されることを前提とした作りになっています。  個別のアクションからこれらを毎回指定するのは面倒なので、ビューファイルの読み込み処理を ラッピングした処理を Controller クラスの render() メソッドとして実装します。
     *
     * @param array $variables テンプレートに渡す変数の連想配列
     * @param string $template ビューファイル名(nullの場合はアクション名を使う)
     * @param string $layout レイアウトファイル名
     * @return string レンダリングしたビューファイルの内容
     */
    protected function render($variables = array(), $template = null, $layout = 'layout')
    {
        // echo 111;
        $defaults = array(
            'request'  => $this->request,
            'base_url' => $this->request->getBaseUrl(),
            'session'  => $this->session,
        );
        // print_r($defaults);
        // print_r($variables);
        // print_r($this->request);
        // var_dump($this->request);
        // var_dump($template);

        $view = new View($this->application->getViewDir(), $defaults);

        // print_r($view);
        // print_r($template);
        if (is_null($template)) {
            $template = $this->action_name;
            if ($template == 'post') {  //投稿後にpost_indexに遷移したいから手っ取り早く書き換える。普通に綺麗にやろうとすると時間がかかりそう
                $template = 'post_index';
            }
            // echo 111;
        }
        // print_r($this->action_name);
        // print_r($template);

        $path = $this->controller_name . '/' .$template;
        // print_r($path);
        // print_r($layout);

        return $view->render($path, $variables, $layout);
    }

    /**
     * 404エラー画面を出力
     *
     * @throws HttpNotFoundException
     */
    protected function forward404()
    {
        throw new HttpNotFoundException('Forwarded 404 page from '
            . $this->controller_name . '/' . $this->action_name);
    }

    /**
     * 指定されたURLへリダイレクト
     *
     * @param string $url
     */
    protected function redirect($url)
    {
        if (!preg_match('#https?://#', $url)) {
            $protocol = $this->request->isSsl() ? 'https://' : 'http://';
            $host = $this->request->getHost();
            $base_url = $this->request->getBaseUrl();

            $url = $protocol . $host . $base_url . $url;
        }

        $this->response->setStatusCode(302, 'Found');
        $this->response->setHttpHeader('Location', $url);
    }

    /**
     * CSRFトークンを生成
     *
     * @param string $form_name
     * @return string $token
     */
    protected function generateCsrfToken($form_name)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, array());
        if (count($tokens) >= 10) {
            array_shift($tokens);
        }

        $token = sha1($form_name . session_id() . microtime());
        $tokens[] = $token;

        $this->session->set($key, $tokens);

        return $token;
    }

    /**
     * CSRFトークンが妥当かチェック。トークンはリクエストされた際に POST パラメータとして送信されます。セッション上に格納され ているトークンから POST されたトークンを探すのが checkCsrfToken() メソッドです。
     *
     * @param string $form_name
     * @param string $token
     * @return boolean
     */
    protected function checkCsrfToken($form_name, $token)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, array());

        if (false !== ($pos = array_search($token, $tokens, true))) {  // array_search() 関数を用いて実際にセッション上にトークンが格納され ているかを判定
            unset($tokens[$pos]);
            $this->session->set($key, $tokens);
            // echo 111;

            return true;
        }
        // echo 111;

        return false;
    }

    /**
     * 指定されたアクションが認証済みでないとアクセスできないか判定
     *
     * @param string $action
     * @return boolean
     */
    protected function needsAuthentication($action)
    {
        if ($this->auth_actions === true
            || (is_array($this->auth_actions) && in_array($action, $this->auth_actions))
        ) {
            return true;
        }

        return false;
    }
}

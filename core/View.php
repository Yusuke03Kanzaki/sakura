<?php
 
class View
{
    protected $base_dir;  //  /Applications/MAMP/htdocs/task/views　常にこれ？
    protected $defaults;
    protected $layout_variables = array();

    /**
     * コンストラクタ
     *
     * @param string $base_dir
     * @param array $defaults
     */
    public function __construct($base_dir, $defaults = array())
    {
        $this->base_dir = $base_dir;
        $this->defaults = $defaults;
    }

    /**
     * レイアウトに渡す変数を指定
     *
     * @param string $name
     * @param mixed $value
     */
    public function setLayoutVar($name, $value)
    {
        $this->layout_variables[$name] = $value;
    }

    /**
     * ビューファイルをレンダリング。ビューファイルの読み込みを行う  PPHP248p
     *
     * @param string $_path  ビューファイルへのパス
     * @param array $_variables  ビューファイルに渡す変数
     * @param mixed $_layout  レイアウトファイル名の指定。指定が必要なのはControllerクラスが読み出された際だけ。falseの場合レイアウトの読み込みをしない
     * @return string
     */
    public function render($_path, $_variables = array(), $_layout = false) 
    {
        // print_r($_path);
        // print_r($_variables);
        $_file = $this->base_dir . '/' . $_path . '.php';
        // echo 1;
        // print_r($_file);
        // print_r($this->base_dir);  //  /Applications/MAMP/htdocs/task/views　常にこれ？
        // print_r($_path);
        // print_r($this->defaults);

        extract(array_merge($this->defaults, $_variables));

        ob_start();
        ob_implicit_flush(0);

        // var_dump($_file);
        require $_file;
        // echo 222;

        $content = ob_get_clean();
        // print_r($content);

        if ($_layout) {
            $content = $this->render($_layout,
                array_merge($this->layout_variables, array(
                    '_content' => $content,
                )
            ));
        }
        // print_r($content);
        // var_dump($content);

        return $content;
    }

    /**
     * 指定された値をHTMLエスケープする
     *
     * @param string $string
     * @return string
     */
    public function escape($string)
    {

        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

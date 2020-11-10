<?php

class Router
{
    protected $routes; //compileRoutesメソッドで内部用に変換されたルーティングが入っている

    /**
     * コンストラクタ
     *
     * @param array $definitions
     */
    public function __construct($definitions)  //definitions　定義　
    {
        // print_r($definitions);  //MiniBlogApplicationのルーティングが入っている
        $this->routes = $this->compileRoutes($definitions);
    }

    /**
     * ルーティング定義配列を内部用に変換する
     *
     * @param array $definitions
     * @return array
     */
    public function compileRoutes($definitions)
    {
        $routes = array();

        foreach ($definitions as $url => $params) {
            $tokens = explode('/', ltrim($url, '/'));  //explode関数で連想配列のキーの中にある / を削除。ltrim関数で文字列先頭にできた空白を削除。
            foreach ($tokens as $i => $token) {  //$iは$tokensに入っている配列のインデックス番号が代入される
                //  strpos関数で$tokenの１文字目が’:’かを調べ、そうであればtrue。substr関数で’:’を削除し$tokenを$nameに代入。$tokenに正規表現形式にした$nameを代入  35
                if (0 === strpos($token, ':')) {
                    $name = substr($token, 1);
                    $token = '(?P<' . $name . '>[^/]+)';
                }
                $tokens[$i] = $token;
            }

            $pattern = '/' . implode('/', $tokens);  //implodeで配列の値に’/’を付け結合  "/status/post"  implodeの前に ‘/’ が無いと"status/post"となってしまう
            $routes[$pattern] = $params;
        }

        return $routes;  //Routerクラスの変数$routesに代入
    }

    /**
     * 指定されたPATH_INFOを元にルーティングパラメータを特定する
     *
     * @param string $path_info
     * @return array|false
     */
    public function resolve($path_info) //  /about.php
    {
        // print_r($path_info);
        if ('/' !== substr($path_info, 0, 1)) {  //substr関数で$path_infoの１文字目が’/’出なければ、$path_infoの頭に’/’をつける
            $path_info = '/' . $path_info;
        }
        // print_r($path_info);
        // print_r($this->routes);  
        // $path_info = str_replace('.php', '', $path_info);  // .phpを削除

        foreach ($this->routes as $pattern => $params) {
            // echo 111;
            // var_dump($pattern);
            // print_r($params);
            // var_dump(preg_match('#^' . $pattern . '$#', $path_info, $matches));
            if (preg_match('#^' . $pattern . '$#', $path_info, $matches)) {  //$patternと$path_infoがいってしていれば true
                // echo 111;
                // var_dump($matches);
                // var_dump($params);
                $params = array_merge($params, $matches); 
                // echo 111;
                // print_r($params);

                return $params;
            }
        }

        return false;
    }
}

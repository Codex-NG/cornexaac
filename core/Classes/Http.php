<?php namespace App\Classes;

class Http {

    /**
     * Store middlewares
     *
     * @var array
     */
    public static $middlewares = [];

    /**
     * Store url parameters
     *
     * @var array
     */
    public static $parameters = [];

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        // 
    }

    /**
     * Return a UrlGenerator object 
     *
     * @return \Illuminate\Routing\UrlGenerator
     */
    public function url()
    {
        $routes = new \Illuminate\Routing\RouteCollection;

        $context = \Illuminate\Http\Request::createFromBase(
            \Illuminate\Http\Request::capture()
        );

        return new \Illuminate\Routing\UrlGenerator($routes, $context);
    }

    /**
     * Extend middlewares
     *
     * @return void
     */
    public static function extend($rule, $callback)
    {
        static::$middlewares[$rule] = $callback;
    }

    /**
     * Run middlewares to set specially requirments in order to proceed
     *
     * @return 
     */
    public function middleware($rules)
    {
        $parameters = [];

        array_walk($rules, function ($rule) use(&$parameters) {
            $explode = explode(':', $rule);
            $rule = $explode[0];

            $redirect = ($rule == 'auth') ? 'login' : 'index';

            $callback = static::$middlewares[$rule];

            if (count($explode) >= 2) {
                // has parameters
                $rule = $explode[0];

                array_walk(array_values($explode), function($value, $i) use(&$parameters){
                    if (isset(static::$parameters[$value])) {

                        $parameters[] = static::$parameters[$value];
                    }  
                });

                if (! $callback($parameters)) {
                    redirect('?subtopic='.$redirect);
                }
            }

            if (! $callback($parameters)) {
                redirect('?subtopic='.$redirect);
            }
        });
    }

    /**
     * Handle a URL request
     *
     * @return 
     */
    public function request($url, $callback)
    {
        if (! $this->match($url)) return false;

        if (count(func_get_args()) == 3) {
            $this->middleware(func_get_arg(1));

            $callback = func_get_arg(2);

            return call_user_func($callback, $this);
        }

        if (count(func_get_args()) == 2 && is_array(func_get_arg(1))) {
            return $this->middleware(func_get_arg(1));
        }

        return call_user_func($callback, $this);
    }

    /**
     * Check if current URL request is $match
     *
     * @return boolean
     */
    public function match($url)
    {
        // Get the URL, replace every & and = with /. 
        $query = preg_replace('/=|&/i', '/', http_build_query($_GET));

        // Explode the $url
        $url = explode('/', $url);

        // Return the $_GET values
        $values = array_values($_GET);

        // Return the $_GET keys
        $keys = array_keys($_GET);

        $custom = [];
        $build = '';

        // Loop the $url that we exploded
        foreach ($url as $i => $value) {

            if (! isset($values[$i])) {
                return false;
            }

            if (preg_match('/{(.*?)}/i', $value)) {
                $custom[$value] = $values[$i]; 
            }

            if (! empty($build) or ! ($build == '')) {
                $build .= '&';
            }

            if (isset($custom[$value])) {
                $build .= $keys[$i] . '=' . $custom[$value];
            } else {
                $build .= $keys[$i] . '=' . $value;
            }   

        }

        if (isset($custom)) {
            static::$parameters = $custom;
        }

        return (boolean) (http_build_query($_GET) == $build);
    }

}
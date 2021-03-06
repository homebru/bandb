<?php
    /**
     * Class: Main Controller
     * The logic behind the Chyrp install.
     */
    class MainController {
        # Array: $urls
        # An array of clean URL => dirty URL translations.
        public $urls = array('|/id/([0-9]+)/|'          => '/?action=view&id=$1',
                             '|/page/(([^/]+)/)+|'      => '/?action=page&url=$2',
                             '|/search/|'               => '/?action=search',
                             '|/search/([^/]+)/|'       => '/?action=search&query=$1',
                             '|/archive/([0-9]{4})/([0-9]{2})/|'
                                                        => '/?action=archive&year=$1&month=$2',
                             '|/archive/([0-9]{4})/([0-9]{2})/([0-9]{2})/|'
                                                        => '/?action=archive&year=$1&month=$2&day=$3',
                             '|/([^/]+)/feed/([^/]+)/|' => '/?action=$1&feed&title=$2',
                             '|/([^/]+)/feed/|'         => '/?action=$1&feed');

        # Boolean: $displayed
        # Has anything been displayed?
        public $displayed = false;

        # Array: $context
        # Context for displaying pages.
        public $context = array();

        # Boolean: $feed
        # Is the visitor requesting a feed?
        public $feed = false;

        /**
         * Function: __construct
         * Loads the Twig parser into <Theme>, and sets up the theme l10n domain.
         */
        private function __construct() {
            $this->feed = (isset($_GET['feed']) or (isset($_GET['action']) and $_GET['action'] == "feed"));
            $this->post_limit = Config::current()->posts_per_page;

            $cache = (is_writable(INCLUDES_DIR."/caches") and
                      !DEBUG and
                      !PREVIEWING and
                      !defined('CACHE_TWIG') or CACHE_TWIG);

            if (defined('THEME_DIR'))
                $this->twig = new Twig_Loader(THEME_DIR,
                                              $cache ?
                                                  INCLUDES_DIR."/caches" :
                                                  null) ;
        }

        /**
         * Function: parse
         * Determines the action.
         */
        public function parse($route) {
            $config = Config::current();

            if (empty($route->arg[0]) and !isset($config->routes["/"])) # If they're just at /, don't bother with all this.
                return $route->action = "index";

            # Protect non-responder functions.
            if (in_array($route->arg[0], array("__construct", "parse", "post_from_url", "display", "current")))
                show_404();

            # Feed
            if (preg_match("/\/feed\/?$/", $route->request)) {
                $this->feed = true;
                $this->post_limit = $config->feed_items;

                if ($route->arg[0] == "feed") # Don't set $route->action to "feed" (bottom of this function).
                    return $route->action = "index";
            }

            # Feed with a title parameter
            if (preg_match("/\/feed\/([^\/]+)\/?$/", $route->request, $title)) {
                $this->feed = true;
                $this->post_limit = $config->feed_items;
                $_GET['title'] = $title[1];

                if ($route->arg[0] == "feed") # Don't set $route->action to "feed" (bottom of this function).
                    return $route->action = "index";
            }

            # Paginator
            if (preg_match_all("/\/((([^_\/]+)_)?page)\/([0-9]+)/", $route->request, $page_matches)) {
                foreach ($page_matches[1] as $key => $page_var)
                    $_GET[$page_var] = (int) $page_matches[4][$key];

                if ($route->arg[0] == $page_matches[1][0]) # Don't fool ourselves into thinking we're viewing a page.
                    return $route->action = (isset($config->routes["/"])) ? $config->routes["/"] : "index" ;
            }

            # Viewing a post by its ID
            if ($route->arg[0] == "id") {
                $_GET['id'] = $route->arg[1];
                return $route->action = "id";
            }

            # Archive
            if ($route->arg[0] == "archive") {
                # Make sure they're numeric; there might be a /page/ in there.
                if (isset($route->arg[1]) and is_numeric($route->arg[1]))
                    $_GET['year'] = $route->arg[1];
                if (isset($route->arg[2]) and is_numeric($route->arg[2]))
                    $_GET['month'] = $route->arg[2];
                if (isset($route->arg[3]) and is_numeric($route->arg[3]))
                    $_GET['day'] = $route->arg[3];

                return $route->action = "archive";
            }

            # Searching
            if ($route->arg[0] == "search") {
                if (isset($route->arg[1]))
                    $_GET['query'] = $route->arg[1];

                return $route->action = "search";
            }

            # Custom pages added by Modules, Feathers, Themes, etc.
            foreach ($config->routes as $path => $action) {
                if (is_numeric($action))
                    $action = $route->arg[0];

                preg_match_all("/\(([^\)]+)\)/", $path, $matches);

                if ($path != "/")
                    $path = trim($path, "/");

                $escape = preg_quote($path, "/");
                $to_regexp = preg_replace("/\\\\\(([^\)]+)\\\\\)/", "([^\/]+)", $escape);

                if ($path == "/")
                    $to_regexp = "\$";

                if (preg_match("/^\/{$to_regexp}/", $route->request, $url_matches)) {
                    array_shift($url_matches);

                    if (isset($matches[1]))
                        foreach ($matches[1] as $index => $parameter)
                            $_GET[$parameter] = urldecode($url_matches[$index]);

                    $params = explode(";", $action);
                    $action = $params[0];

                    array_shift($params);
                    foreach ($params as $param) {
                        $split = explode("=", $param);
                        $_GET[$split[0]] = oneof(@$split[1], "");
                    }

                    $route->action = $action;
                }
            }

            # Are we viewing a post?
            $this->post_from_url($route, $route->request);

            # Try viewing a page.
            $route->try["page"] = array($route->arg);
        }

        /**
         * Function: post_from_url
         * Check to see if we're viewing a post, and if it is, handle it.
         *
         * This can also be used for grabbing a Post from a given URL.
         *
         * Parameters:
         *     $route - The route to respond to.
         *     $url - If this argument is passed, it will attempt to grab a post from a given URL.
         *            If a post is found by that URL, it will be returned.
         *     $return_post - Return a Post?
         */
        public function post_from_url($route, $request, $return_post = false) {
            $config = Config::current();

            $post_url = $config->post_url;

            foreach (explode("/", $post_url) as $path)
                foreach (preg_split("/\(([^\)]+)\)/", $path) as $leftover) {
                    $request  = preg_replace("/".preg_quote($leftover)."/", "", $request, 1);
                    $post_url = preg_replace("/".preg_quote($leftover)."/", "", $post_url, 1);
                }

            $args = array_map("urldecode", explode("/", trim($request, "/")));

            $post_url = $this->key_regexp(rtrim($post_url, "/"));
            $post_url_attrs = array();
            preg_match_all("/\(([^\/]+)\)/", $config->post_url, $parameters);
            if (preg_match("/".$post_url."/", rtrim($request, "/"), $matches)) {
                array_shift($matches);

                foreach ($parameters[0] as $index => $parameter)
                    if ($parameter[0] == "(") {
                        if ($parameter == "(id)") {
                            $post_url_attrs = array("id" => $args[$index]);
                            break;
                        } else
                            $post_url_attrs[rtrim(ltrim($parameter, "("), ")")] = $args[$index];
                    }

                if ($return_post)
                    return Post::from_url($post_url_attrs);
                else
                    $route->try["view"] = array($post_url_attrs, $args);
            }
        }

        /**
         * Function: key_regexp
         * Converts the values in $config->post_url to regular expressions.
         *
         * Parameters:
         *     $key - Input URL with the keys from <Post.$url_attrs>.
         *
         * Returns:
         *     $key values replaced with their regular expressions from <Routes->$code>.
         */
        private function key_regexp($key) {
            Trigger::current()->filter(Post::$url_attrs, "url_code");
            return str_replace(array_keys(Post::$url_attrs), array_values(Post::$url_attrs), str_replace("/", "\\/", $key));
        }

        /**
         * Function: index
         * Grabs the posts for the main page.
         */
        public function index() {
            $this->display("pages/index",
                           array("posts" => new Paginator(Post::find(array("placeholders" => true)),
                                                          $this->post_limit)));
        }

        /**
         * Function: archive
         * Grabs the posts for the Archive page when viewing a year or a month.
         */
        public function archive() {
            fallback($_GET['year']);
            fallback($_GET['month']);
            fallback($_GET['day']);

            if (isset($_GET['year']) and isset($_GET['month']) and isset($_GET['day']))
                $posts = new Paginator(Post::find(array("placeholders" => true,
                                                        "where" => array("created_at like" => $_GET['year']."-".$_GET['month']."-".$_GET['day']."%"))),
                                       $this->post_limit);
            elseif (isset($_GET['year']) and isset($_GET['month']))
                $posts = new Paginator(Post::find(array("placeholders" => true,
                                                        "where" => array("created_at like" => $_GET['year']."-".$_GET['month']."%"))),
                                       $this->post_limit);

            $sql = SQL::current();

            if (empty($_GET['year']) or empty($_GET['month'])) {
                if (!empty($_GET['year']))
                    $timestamps = $sql->select("posts",
                                               array("DISTINCT YEAR(created_at) AS year",
                                                     "MONTH(created_at) AS month",
                                                     "created_at AS created_at",
                                                     "COUNT(id) AS posts"),
                                               array("YEAR(created_at)" => $_GET['year']),
                                               "created_at DESC, id DESC",
                                               array(),
                                               null,
                                               null,
                                               array("YEAR(created_at)", "MONTH(created_at)"));
                else
                    $timestamps = $sql->select("posts",
                                               array("DISTINCT YEAR(created_at) AS year",
                                                     "MONTH(created_at) AS month",
                                                     "created_at AS created_at",
                                                     "COUNT(id) AS posts"),
                                               null,
                                               "created_at DESC, id DESC",
                                               array(),
                                               null,
                                               null,
                                               array("YEAR(created_at)", "MONTH(created_at)"));

                $archives = array();
                $archive_hierarchy = array();
                while ($time = $timestamps->fetchObject()) {
                    $year = mktime(0, 0, 0, 1, 0, $time->year);
                    $month = mktime(0, 0, 0, $time->month + 1, 0, $time->year);

                    $posts = Post::find(array("where" => array("created_at like" => when("Y-m", $time->created_at)."%")));

                    $archives[$month] = array("posts" => $posts,
                                              "year" => $time->year,
                                              "month" => strftime("%B", $month),
                                              "timestamp" => $month,
                                              "url" => url("archive/".when("Y/m/", $time->created_at)));

                   $archive_hierarchy[$year][$month] = $posts; 
                }

                $this->display("pages/archive",
                               array("archives" => $archives,
                                     "archive_hierarchy" => $archive_hierarchy),
                               __("Archive"));
            } else {
                if (!is_numeric($_GET['year']) or !is_numeric($_GET['month']))
                    error(__("Error"), __("Please enter a valid year and month."));

                $timestamp = mktime(0, 0, 0, $_GET['month'], oneof(@$_GET['day'], 1), $_GET['year']);
                $depth = isset($_GET['day']) ? "day" : (isset($_GET['month']) ? "month" : (isset($_GET['year']) ? "year" : ""));

                $this->display("pages/archive",
                               array("posts" => $posts,
                                     "archive" => array("year" => $_GET['year'],
                                                        "month" => strftime("%B", $timestamp),
                                                        "day" => strftime("%d", $timestamp),
                                                        "timestamp" => $timestamp,
                                                        "depth" => $depth)),
                               _f("Archive of %s", array(strftime("%B %Y", $timestamp))));
            }
        }

        /**
         * Function: search
         * Grabs the posts for a search query.
         */
        public function search() {
            fallback($_GET['query'], "");
            $config = Config::current();

            if ($config->clean_urls and
                substr_count($_SERVER['REQUEST_URI'], "?") and
                !substr_count($_SERVER['REQUEST_URI'], "%2F")) # Searches with / and clean URLs = server 404
                redirect("search/".urlencode($_GET['query'])."/");

            if (empty($_GET['query']))
                return Flash::warning(__("Please enter a search term."));

            list($where, $params) = keywords($_GET['query'], "post_attributes.value LIKE :query OR url LIKE :query", "posts");

            $results = Post::find(array("placeholders" => true,
                                        "where" => $where,
                                        "params" => $params));

            $ids = array();
            foreach ($results[0] as $result)
                $ids[] = $result["id"];

            if (!empty($ids))
                $posts = new Paginator(Post::find(array("placeholders" => true,
                                                        "where" => array("id" => $ids))),
                                       $this->post_limit);
            else
                $posts = new Paginator(array());

            $this->display(array("pages/search", "pages/index"),
                           array("posts" => $posts,
                                 "search" => $_GET['query']),
                           fix(_f("Search results for \"%s\"", array($_GET['query']))));
        }

        /**
         * Function: drafts
         * Grabs the posts for viewing the Drafts lists.
         */
        public function drafts() {
            $visitor = Visitor::current();

            if (!$visitor->group->can("view_own_draft", "view_draft"))
                show_403(__("Access Denied"), __("You do not have sufficient privileges to view drafts."));

            $posts = new Paginator(Post::find(array("placeholders" => true,
                                                    "where" => array("status" => "draft",
                                                                     "user_id" => $visitor->id))),
                                   $this->post_limit);

            $this->display(array("pages/drafts", "pages/index"),
                           array("posts" => $posts),
                           __("Drafts"));
        }

        /**
         * Function: view
         * Views a post.
         */
        public function view($attrs = null, $args = array()) {
            if (isset($attrs))
                $post = Post::from_url($attrs, array("drafts" => true));
            else
                $post = new Post(array("url" => @$_GET['url']));

            if ($post->no_results)
                return false;

            if ((oneof(@$attrs["url"], @$attrs["clean"]) == "feed") and # do some checking to see if they're trying
                (count(explode("/", trim($post_url, "/"))) > count($args) or              # to view the post or the post's feed.
                 end($args) != "feed"))
                $this->feed = false;

            if (!$post->theme_exists())
                error(__("Error"), __("The feather theme file for this post does not exist. The post cannot be displayed."));

            if ($post->status == "draft")
                Flash::message(__("This post is a draft."));

            if ($post->groups() and !substr_count($post->status, "{".Visitor::current()->group->id."}"))
                Flash::message(_f("This post is only visible by the following groups: %s.", $post->groups()));

            $this->display(array("pages/view", "pages/index"),
                           array("post" => $post, "posts" => array($post)),
                           $post->title());
        }

        /**
         * Function: page
         * Handles page viewing.
         */
        public function page($urls = null) {
            if (isset($urls)) { # Viewing with clean URLs, e.g. /parent/child/child-of-child/
                $valids = Page::find(array("where" => array("url" => $urls)));

                if (count($valids) == count($urls)) { # Make sure all page slugs are valid.
                    foreach ($valids as $page)
                        if ($page->url == end($urls)) # Loop until we reach the last one.
                            break;
                } else
                    return false; # A "link in the chain" is broken
            } else
                $page = new Page(array("url" => $_GET['url']));

            if ($page->no_results)
                return false; # Page not found; the 404 handling is handled externally.

            $this->display(array("pages/page", "pages/".$page->url), array("page" => $page), $page->title);
        }

        /**
         * Function: rss
         * Redirects to /feed (backwards compatibility).
         */
        public function rss() {
            header("HTTP/1.1 301 Moved Permanently");
            redirect(oneof(@Config::current()->feed_url, url("feed")));
        }

        /**
         * Function: id
         * Views a post by its static ID.
         */
        public function id() {
            $post = new Post($_GET['id']);
            redirect($post->url());
        }

        /**
         * Function: toggle_admin
         * Toggles the Admin control panel (if available).
         */
        public function toggle_admin() {
            if (!isset($_SESSION['hide_admin']))
                $_SESSION['hide_admin'] = true;
            else
                unset($_SESSION['hide_admin']);

            redirect("/");
        }

        /**
         * Function: register
         * Process registration. If registration is disabled or if the user is already logged in, it will error.
         */
        public function register() {
            $config = Config::current();
            if (!$config->can_register)
                error(__("Registration Disabled"), __("I'm sorry, but this site is not allowing registration."));

            if (logged_in())
                error(__("Error"), __("You're already logged in."));

            if (!empty($_POST)) {
                $route = Route::current();

                if (empty($_POST['login']))
                    Flash::warning(__("Please enter a username for your account."));
                elseif (count(User::find(array("where" => array("login" => $_POST['login'])))))
                    Flash::warning(__("That username is already in use."));

                if (empty($_POST['password1']) and empty($_POST['password2']))
                    Flash::warning(__("Password cannot be blank."));
                elseif ($_POST['password1'] != $_POST['password2'])
                    Flash::warning(__("Passwords do not match."));

                if (empty($_POST['email']))
                    Flash::warning(__("E-mail address cannot be blank."));
                elseif (!preg_match("/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/", $_POST['email']))
                    Flash::warning(__("Invalid e-mail address."));

                if (!Flash::exists("warning")) {
                    $user = User::add($_POST['login'], $_POST['password1'], $_POST['email']);

                    Trigger::current()->call("user_registered", $user);

                    $_SESSION['user_id'] = $user->id;

                    Flash::notice(__("Registration successful."), "/");
                }
            }

            $this->display("forms/user/register", array(), __("Register"));
        }

        /**
         * Function: login
         * Process logging in. If the username and password are incorrect or if the user is already logged in, it will error.
         */
        public function login() {
            if (logged_in())
                error(__("Error"), __("You're already logged in."));

            if (!empty($_POST)) {
                fallback($_POST['login']);
                fallback($_POST['password']);

                $trigger = Trigger::current();

                if ($trigger->exists("authenticate"))
                    return $trigger->call("authenticate");

                if (!User::authenticate($_POST['login'], $_POST['password']))
                    if (!count(User::find(array("where" => array("login" => $_POST['login'])))))
                        Flash::warning(__("There is no user with that login name."));
                    else
                        Flash::warning(__("Password incorrect."));

                if (!Flash::exists("warning")) {
                    $user = new User(array("login" => $_POST['login']));
                    $_SESSION['user_id'] = $user->id;

                    $redirect = @$_SESSION['redirect_to'];
                    unset($_SESSION['redirect_to']);

                    Flash::notice(__("Logged in."), oneof($redirect, "/"));
                }
            }

            $this->display("forms/user/login", array(), __("Log In"));
        }

        /**
         * Function: logout
         * Logs the current user out. If they are not logged in, it will error.
         */
        public function logout() {
            if (!logged_in())
                error(__("Error"), __("You aren't logged in."));

            session_destroy();

            session();

            Flash::notice(__("Logged out."), "/");
        }

        /**
         * Function: controls
         * Updates the current user when the form is submitted. Shows an error if they aren't logged in.
         */
        public function controls() {
            if (!logged_in())
                error(__("Error"), __("You must be logged in to access this area."));

            if (!empty($_POST)) {
                $visitor = Visitor::current();

                $password = (!empty($_POST['new_password1']) and $_POST['new_password1'] == $_POST['new_password2']) ?
                                User::hashPassword($_POST['new_password1']) :
                                $visitor->password ;

                $visitor->update($visitor->login,
                                 $password,
                                 $_POST['email'],
                                 $_POST['full_name'],
                                 $_POST['website'],
                                 $visitor->group->id);

                Flash::notice(__("Your profile has been updated."), "/");
            }

            $this->display("forms/user/controls", array(), __("Controls"));
        }

        /**
         * Function: lost_password
         * Handles e-mailing lost passwords to a user's email address.
         */
        public function lost_password() {
            if (!empty($_POST)) {
                $user = new User(array("login" => $_POST['login']));
                if ($user->no_results) {
                    Flash::warning(__("Invalid user specified."));
                    return $this->display("forms/user/lost_password", array(), __("Lost Password"));
                }

                $new_password = random(16);

                $user->update($user->login,
                              User::hashPassword($new_password),
                              $user->email,
                              $user->full_name,
                              $user->website,
                              $user->group_id);

                $sent = email($user->email,
                              __("Lost Password Request"),
                              _f("%s,\n\nWe have received a request for a new password for your account at %s.\n\nPlease log in with the following password, and feel free to change it once you've successfully logged in:\n\t%s",
                                 array($user->login, Config::current()->name, $new_password)));

                if ($sent)
                    Flash::notice(_f("An e-mail has been sent to your e-mail address that contains a new password. Once you have logged in, you can change it at <a href=\"%s\">User Controls</a>.",
                                  array(url("controls"))));
                else {
                    # Set their password back to what it was originally.
                    $user->update($user->login,
                                  $user->password,
                                  $user->email,
                                  $user->full_name,
                                  $user->website,
                                  $user->group_id);

                    Flash::warning(__("E-Mail could not be sent. Password change cancelled."));
                }
            }

            $this->display("forms/user/lost_password", array(), __("Lost Password"));
        }

        /**
         * Function: feed
         * Grabs posts for the feed.
         */
        public function feed($posts = null) {
            fallback($posts, Post::find(array("limit" => Config::current()->feed_items)));

            header("Content-Type: application/atom+xml; charset=UTF-8");

            if (!is_array($posts))
                $posts = $posts->paginated;

            $latest_timestamp = 0;
            foreach ($posts as $post)
                if (strtotime($post->created_at) > $latest_timestamp)
                    $latest_timestamp = strtotime($post->created_at);

            require INCLUDES_DIR."/feed.php";
        }

        /**
         * Function: display
         * Display the page.
         *
         * If "posts" is in the context and the visitor requested a feed, they will be served.
         *
         * Parameters:
         *     $file - The theme file to display.
         *     $context - The context for the file.
         *     $title - The title for the page.
         */
        public function display($file, $context = array(), $title = "") {
            if (is_array($file))
                for ($i = 0; $i < count($file); $i++) {
                    $check = ($file[$i][0] == "/" or preg_match("/[a-zA-Z]:\\\/", $file[$i])) ?
                                 $file[$i] :
                                 THEME_DIR."/".$file[$i] ;

                    if (file_exists($check.".twig") or ($i + 1) == count($file))
                        return $this->display($file[$i], $context, $title);
                }

            $this->displayed = true;

            $route = Route::current();
            $trigger = Trigger::current();

            # Serve feeds.
            if ($this->feed) {
                if ($trigger->exists($route->action."_feed"))
                    return $trigger->call($route->action."_feed", $context);

                if (isset($context["posts"]))
                    return $this->feed($context["posts"]);
            }

            $this->context = array_merge($context, $this->context);

            $visitor = Visitor::current();
            $config = Config::current();
            $theme = Theme::current();

            $theme->title = $title;

            $this->context["theme"]        = $theme;
            $this->context["flash"]        = Flash::current();
            $this->context["trigger"]      = $trigger;
            $this->context["modules"]      = Modules::$instances;
            $this->context["feathers"]     = Feathers::$instances;
            $this->context["title"]        = $title;
            $this->context["site"]         = $config;
            $this->context["visitor"]      = $visitor;
            $this->context["route"]        = Route::current();
            $this->context["hide_admin"]   = isset($_COOKIE["hide_admin"]);
            $this->context["version"]      = CHYRP_VERSION;
            $this->context["now"]          = time();
            $this->context["debug"]        = DEBUG;
            $this->context["POST"]         = $_POST;
            $this->context["GET"]          = $_GET;
            $this->context["sql_queries"] =& SQL::current()->queries;

            $this->context["visitor"]->logged_in = logged_in();

            $this->context["enabled_modules"] = array();
            foreach ($config->enabled_modules as $module)
                $this->context["enabled_modules"][$module] = true;

            $context["enabled_feathers"] = array();
            foreach ($config->enabled_feathers as $feather)
                $this->context["enabled_feathers"][$feather] = true;

            $this->context["sql_debug"] =& SQL::current()->debug;

            $trigger->filter($this->context, array("main_context", "main_context_".str_replace("/", "_", $file)));

            $file = ($file[0] == "/" or preg_match("/[a-zA-Z]:\\\/", $file)) ? $file : THEME_DIR."/".$file ;
            if (!file_exists($file.".twig"))
                error(__("Template Missing"), _f("Couldn't load template: <code>%s</code>", array($file.".twig")));

            try {
                return $this->twig->getTemplate($file.".twig")->display($this->context);
            } catch (Exception $e) {
                $prettify = preg_replace("/([^:]+): (.+)/", "\\1: <code>\\2</code>", $e->getMessage());
                $trace = debug_backtrace();
                $twig = array("file" => $e->filename, "line" => $e->lineno);
                array_unshift($trace, $twig);
                error(__("Error"), $prettify, $trace);
            }
        }

        /**
         * Function: resort
         * Queue a failpage in the event that none of the routes are successful.
         */
        public function resort($file, $context, $title = null) {
            $this->fallback = array($file, $context, $title);
            return false;
        }

        /**
         * Function: current
         * Returns a singleton reference to the current class.
         */
        public static function & current() {
            static $instance = null;
            return $instance = (empty($instance)) ? new self() : $instance ;
        }
    }


<?php

class Home extends Controller {

    function index($request) {
        $db = new Database();

        $categories = $db->read("SELECT * FROM categories;");

        $category_id = null;
        $category_name = isset($request[0]) ? strtolower($request[0]) : null;
        if (isset($category_name)) {
            $category = $db->read("SELECT * FROM categories WHERE LOWER(name) = '" . addslashes($category_name) . "';");
            if (!empty($category)) {
                $category_id = intval($category[0]->id);
//                $category_id = (int)$category[0]->id;
            }
//            $category_id = isset($category[0]->id) ? intval($category[0]->id) : null;
        }
        $sql = "SELECT * FROM posts";
        if (isset($category_id)) {
            $sql .= " WHERE category_id = " . $category_id;
//            $sql = $sql . " WHERE category_id = " . $category_id;
        }
        $sql .= " ORDER BY created_at DESC";
        $posts = $db->read($sql);
        foreach ($posts as $post) {
            $post->category_name = '';
            foreach ($categories as $category) {
                if ($post->category_id == $category->id) {
                    $post->category_name = $category->name;
                }
            }
        }

        $this->view("home", [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    function posts($request) {
        $db = new Database();

        $id = null;
        $id = isset($request[0]) ? intval($request[0]) : null;
        $post = $db->read("SELECT * FROM posts WHERE id= '" . $id . "';");
        if (empty($post)) {
            echo "error";die;
        }

        $this->view("post", [
            'post' => $post[0]
        ]);
    }

    function login($request) {
        if (!empty($request['Login'])) {
            $db = new Database();

            $username = isset($request['username']) ? $request['username'] : null;
            if (empty($username)) {
                return $this->view("login", ['error' => 'Empty username']);
            }
            $password = isset($request['password']) ? $request['password'] : null;
            //todo
            //$hashed_password = password_hash($password, PASSWORD_BCRYPT);
            //var_dump($hashed_password);die;
            $admin = $db->read("SELECT * FROM admins WHERE username = '" . addslashes($username) . "';");
            if (!empty($admin)) {
                if (!password_verify($password, $admin[0]->password)) {
                    return $this->view("login", ['error' => 'Invalid username or password']);
                }
                $_SESSION['admin'] = $admin[0]->username;
                header('Location: ' . BASE_URL . 'admin');
                // return $this->view("admin", []);
            } else {
                return $this->view("login", ['error' => 'Invalid username or password']);
            }
        }
        $this->view("login", []);
    }
}

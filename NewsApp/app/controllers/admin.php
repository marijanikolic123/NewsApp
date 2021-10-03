<?php

class Admin extends Controller {

    function index($request) {
        $db = new Database();

        $categories = $db->read("SELECT * FROM categories;");

        $posts = $db->read("SELECT * FROM posts ORDER BY created_at DESC");
        foreach ($posts as $post) {
            $post->category_name = '';
            foreach ($categories as $category) {
                if ($post->category_id == $category->id) {
                    $post->category_name = $category->name;
                }
            }
        }

        $update_posts = null;
        $posts_id = isset($request[0]) ? intval($request[0]) : null;
        if (!empty($posts_id)) {
            $_update_posts = $db->read("SELECT * FROM posts WHERE id = " . $posts_id);
            if (!empty($_update_posts)) {
                $update_posts = $_update_posts[0];
            }
        }

        $subscriptions = $db->read("SELECT * FROM subscriptions");

        $this->view("admin", [
            'posts' => $posts,
            'categories' => $categories,
            'update_posts' => $update_posts,
            'subscriptions' => $subscriptions,
        ]);
    }

    function saveNews($request) {
        $db = new Database();

        //TODO: proveriti da nijedan podatak osim highligh i description nije empty
        $title = isset($request['title']) ? $request['title'] : null;
        $highlight = isset($request['highlight']) ? $request['highlight'] : null;
        $description = isset($request['description']) ? $request['description'] : null;
        $category_id = isset($request['category_id']) ? (int)$request['category_id'] : null;

        $id = !empty($request['id']) ? (int)$request['id'] : null;

        if (empty($id)) {
            // slati mailove za tu kategoriju
            $created = $db->write("INSERT INTO posts (category_id, title, highlight, description, created_at, updated_at) VALUES ("
                . $category_id . ', ' // category_id
                . "'" . addslashes($title) . "', " //title
                . "'" . addslashes($highlight) . "', " //highlight
                . "'" . addslashes($description) . "', " //description
                . "CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);"); // created_at, updated_at
            if (!$created) {
                // error handling
            }
        } else {
            // dohvati red sa $id iz baze
            // uporedi svaki value-a da li postoji izmena
            // ukoliko postoji izmena, slati mailove
            $updated = $db->update("UPDATE posts SET "
                . "category_id = " . $category_id . ", "
                . "title = '" . addslashes($title) . "', "
                . "highlight = '" . addslashes($highlight) . "', "
                . "description = '" . addslashes($description) . "' "
                . "WHERE id = " . $id);
            if (!$updated) {
                // error handling
            }
        }

        return $this->index($request);
    

}


<!DOCTYPE html>  
    <head>  
        <title>Post</title>
    </head>  
    <body>
        <?php
            echo "<h1> " . $data['post']->title . "</h1>";
            echo "<h3> " . $data['post']->highlight . "</h3>";
            echo "<h4> " . $data['post']->description . "</h4>";
            echo "<a href='" . BASE_URL . "subscribe/index/posts/" . $data['post']->id . "'>Subscribe</a>&nbsp;&nbsp;";
            echo "<a href='" . BASE_URL . "subscribe/index/categories/" . $data['post']->category_id . "'>Subscribe to category</a>";
            echo "<hr/>";        
        ?>
  </body>  
</html>  

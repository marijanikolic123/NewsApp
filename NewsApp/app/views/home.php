<!DOCTYPE html>  
    <head>  
        <title>Home</title>
    </head> 

    <body>
        <?php
            echo "| <a href='" . BASE_URL . "home/'>Home</a> | ";
            foreach ($data['categories'] as $category) {
                echo "<a href='" . BASE_URL . "home/index/" . $category->name . "'>" . $category->name . "</a> | ";
            }
        ?>
        <br/>
        <?php
            foreach ($data['posts'] as $posts) {
                echo "<h1> <a href='" . BASE_URL . "home/posts/" . $posts->id . "'>" . $posts->title ."</a></h1>";
                echo "<h3> " . $posts->highlight . "</h3>";
                echo "<p>Category: " . $posts->category_name . "</p>";
                echo "<a href='" . BASE_URL . "subscribe/index/posts/" . $posts->id . "'>Subscribe</a>&nbsp;&nbsp;";
                echo "<a href='" . BASE_URL . "subscribe/index/categories/" . $posts->category_id . "'>Subscribe to category</a>";
                echo "<hr/>";
            }
        ?>
  </body>  
</html>  

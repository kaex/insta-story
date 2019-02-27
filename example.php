<?php
include 'func.php';
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $stories = GetAllStories($username);
    foreach ($stories['story'] as $story) {
        $check = '/mp4/m';
        preg_match_all($check, $story, $matches, PREG_SET_ORDER, 0);
        if (empty($matches)) {
            echo "<a href=$story&dl=1><img src=$story></a>";
        } else {
            echo '<video width="320" height="240" controls>';
            echo '<source src="' . $story . '" type="video/mp4">';
            echo '</video>';
            echo "<a href=$story&dl=1>Download</a>";
        }
    }
}
?>
<div id="center" style="text-align: center; margin-top: 300px;">
<form action="" method="post">
    <input name="username">
    <input type="submit" name="submit">
</form>
</div>

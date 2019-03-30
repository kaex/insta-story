<?php
require_once 'class.instagram.php';
if (isset($_POST['submit'])) {
    $story = new instagram_story();
    $story->getStory($_POST['username']);
}
?>
<div id="center" style="text-align: center; margin-top: 300px;">
    <form action="" method="post">
        <input name="username">
        <input type="submit" name="submit">
    </form>
</div>

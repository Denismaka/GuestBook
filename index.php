<?php
$title = 'GuestBook';
require("layouts/header.php")
?>

<div class="container">
    <h1>GuestBook</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="username" placeholder="Enter your name" class="form-control">
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Enter your message" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>






<?php require("layouts/footer.php") ?>
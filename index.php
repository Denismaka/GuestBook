<?php
require_once "class/message.php";
require_once "class/GuestBook.php";
$errors = null;
$success = false;
if (isset($_POST['username']) && isset($_POST['message'])) {
    $message = new Message($_POST['username'], $_POST['message']);
    if ($message->isValid()) {
        $guestBook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');
        $guestBook->addMessage($message);
        $success = true;
        $_POST = [];
    } else {
        $errors = $message->getErrors();
    }
}
$title = 'GuestBook';
require "layouts/header.php";
?>

<div class="container">
    <h1>GuestBook</h1>
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            Formulaire invalide
        </div>
    <?php endif; ?>
    <?php if ($success) : ?>
        <div class="alert alert-success">
            Message ajouté avec succès
        </div>
    <?php endif; ?>
    <!-- Formulaire -->
    <form action="" method="post">
        <div class="form-group">
            <input value="<?= htmlentities($_POST['username'] ?? '') ?>" type="text" name="username" placeholder="Enter your name" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
            <?php if (isset($errors['username'])) : ?>
                <div class="invalid-feedback"><?= $errors['username'] ?></div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Enter your message" class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['message'] ?? '') ?></textarea>
            <?php if (isset($errors['message'])) : ?>
                <div class="invalid-feedback"><?= $errors['message'] ?></div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php require "layouts/footer.php"; ?>
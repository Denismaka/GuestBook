<?php
// Import des classes nécessaires
require_once "class/message.php";
require_once "class/GuestBook.php";

// Initialisation des variables de contrôle
$errors = null;
$success = false;
$guestBook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');

// Traitement du formulaire lors d'une soumission
if (isset($_POST['username']) && isset($_POST['message'])) {
    // Création d'un nouveau message avec les données du formulaire
    $message = new Message($_POST['username'], $_POST['message']);

    // Validation du message
    if ($message->isValid()) {
        // Création/ouverture du livre d'or et ajout du message
        $guestBook->addMessage($message);
        $success = true;
        $_POST = []; // Réinitialisation du formulaire après succès
    } else {
        // Récupération des erreurs de validation
        $errors = $message->getErrors();
    }
}

$messages = $guestBook->getMessages();

// Configuration de la page
$title = 'GuestBook';
require "layouts/header.php";
?>

<div class="container">
    <h1>GuestBook</h1>

    <!-- Affichage des messages d'erreur -->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            Formulaire invalide
        </div>
    <?php endif; ?>

    <!-- Message de succès -->
    <?php if ($success) : ?>
        <div class="alert alert-success">
            Message ajouté avec succès
        </div>
    <?php endif; ?>

    <!-- Formulaire de saisie -->
    <form action="" method="post" class="mt-4">
        <!-- Champ nom d'utilisateur -->
        <div class="form-group mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input
                value="<?= htmlentities($_POST['username'] ?? '') ?>"
                type="text"
                name="username"
                id="username"
                placeholder="Enter your name"
                class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
            <?php if (isset($errors['username'])) : ?>
                <div class="invalid-feedback"><?= $errors['username'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Champ message -->
        <div class="form-group mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea
                name="message"
                id="message"
                placeholder="Enter your message"
                class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"
                style="resize: none;"
                rows="4"><?= htmlentities($_POST['message'] ?? '') ?></textarea>
            <?php if (isset($errors['message'])) : ?>
                <div class="invalid-feedback"><?= $errors['message'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Bouton de soumission -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <?php if (!empty($message)): ?>
        <h1 class="mt-4">Vos messages</h1>
        <?php foreach ($messages as $message) : ?>
            <?= $message->toHTML(); ?>
        <?php endforeach ?>
    <?php endif ?>
</div>

<?php require "layouts/footer.php"; ?>
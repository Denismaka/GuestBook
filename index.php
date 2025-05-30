<?php
// Import des classes nécessaires
require_once "class/message.php";
require_once "class/GuestBook.php";

// Initialisation des variables de contrôle
$errors = null;
$success = false;

// Traitement du formulaire lors d'une soumission
if (isset($_POST['username']) && isset($_POST['message'])) {
    // Création d'un nouveau message avec les données du formulaire
    $message = new Message($_POST['username'], $_POST['message']);

    // Validation du message
    if ($message->isValid()) {
        // Création/ouverture du livre d'or et ajout du message
        $guestBook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');
        $guestBook->addMessage($message);
        $success = true;
        $_POST = []; // Réinitialisation du formulaire après succès
    } else {
        // Récupération des erreurs de validation
        $errors = $message->getErrors();
    }
}

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
    <form action="" method="post">
        <!-- Champ nom d'utilisateur -->
        <div class="form-group">
            <input
                value="<?= htmlentities($_POST['username'] ?? '') ?>"
                type="text"
                name="username"
                placeholder="Enter your name"
                class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
            <?php if (isset($errors['username'])) : ?>
                <div class="invalid-feedback"><?= $errors['username'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Champ message -->
        <div class="form-group">
            <textarea
                name="message"
                placeholder="Enter your message"
                class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"><?= htmlentities($_POST['message'] ?? '') ?></textarea>
            <?php if (isset($errors['message'])) : ?>
                <div class="invalid-feedback"><?= $errors['message'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php require "layouts/footer.php"; ?>
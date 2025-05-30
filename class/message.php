<?php

/**
 * Classe Message
 * Gère la création et la validation des messages du livre d'or
 */
class Message
{
    // Constantes de validation
    public const MIN_USERNAME_LENGTH = 3;
    public const MIN_MESSAGE_LENGTH = 10;

    // Propriétés du message
    private string $username;
    private string $message;
    private DateTime $date;

    public static function fromJSON(string $json): Message
    {
        $data = json_decode($json, true);
        return new Message($data['username'], $data['message'], new DateTime("@" . $data['date']));
    }

    /**
     * Constructeur de la classe Message
     * @param string $username Nom de l'utilisateur
     * @param string $message Contenu du message
     * @param DateTime|null $date Date du message (utilise la date actuelle si non fournie)
     */
    public function __construct(string $username, string $message, ?DateTime $date = null)
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?? new DateTime();
    }

    /**
     * Vérifie si le message est valide
     * @return bool true si le message est valide, false sinon
     */
    public function isValid(): bool
    {
        return empty($this->getErrors());
    }

    /**
     * Récupère les erreurs de validation du message
     * @return array Tableau des messages d'erreur
     */
    public function getErrors(): array
    {
        $errors = [];
        if (strlen($this->username) < self::MIN_USERNAME_LENGTH) {
            $errors['username'] = "Le nom d'utilisateur doit contenir au moins 3 caractères";
        }
        if (strlen($this->message) < self::MIN_MESSAGE_LENGTH) {
            $errors['message'] = "Le message doit contenir au moins 10 caractères";
        }
        return $errors;
    }

    public function toHtml(): string
    {
        $username = htmlentities($this->username);
        $this->date->setTimezone(new DateTimeZone('Africa/Kinshasa'));
        $date = $this->date->format('d/m/Y à H:i');
        $message = nl2br(htmlentities($this->message));
        return <<<HTML
        <p>
            <strong>{$username}</strong> <em>Le {$date}</em><br>
            {$message}
        </p>
        HTML;
    }

    /**
     * Convertit le message en format JSON
     * @return string Représentation JSON du message
     */
    public function toJSON(): string
    {
        return json_encode([
            'username' => $this->username,
            'message' => $this->message,
            'date' => $this->date->getTimestamp()
        ]);
    }
}

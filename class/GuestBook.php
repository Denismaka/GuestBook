<?php
require_once "class/message.php";

/**
 * Classe GuestBook
 * Gère le stockage et la récupération des messages du livre d'or
 */
class GuestBook
{
    // Chemin du fichier de stockage des messages
    private string $file;

    /**
     * Constructeur de la classe GuestBook
     * @param string $file Chemin du fichier de stockage
     */
    public function __construct(string $file)
    {
        // Création du répertoire si nécessaire
        $directory = dirname($file);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        // Création du fichier s'il n'existe pas
        if (!file_exists($file)) {
            touch($file);
        }
        $this->file = $file;
    }

    /**
     * Ajoute un message au livre d'or
     * @param Message $message Le message à ajouter
     */
    public function addMessage(Message $message): void
    {
        file_put_contents($this->file, $message->toJSON() . PHP_EOL, FILE_APPEND);
    }
}

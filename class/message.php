<?php
class Message
{
    const MIN_USERNAME_LENGTH = 3;
    const MIN_MESSAGE_LENGTH = 10;
    private string $username;
    private string $message;
    private DateTime $date;

    public function __construct(string $username,  string $message, ?DateTime $date = null)
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?? new DateTime();
    }
    public function isValid(): bool
    {
        return empty($this->getErrors());
    }

    public function getErrors(): array
    {
        $errors = [];
        if (strlen($this->username) < self::MIN_USERNAME_LENGTH) {
            $errors[] = "Le nom d'utilisateur doit contenir au moins 3 caractères";
        }
        if (strlen($this->message) < self::MIN_MESSAGE_LENGTH) {
            $errors[] = "Le message doit contenir au moins 10 caractères";
        }
        return $errors;
    }
}

<?php

// Codici colore ANSI
$RED = "\033[31m";
$GREEN = "\033[32m";
$RESET = "\033[0m";

// 1. Lunghezza
function checkLength($string, &$errors) {
    if (strlen($string) < 8) {
        $errors[] = "La password deve essere lunga almeno 8 caratteri.";
        return false;
    }
    return true;
}

// 2. Maiuscola
function checkUpperCase($string, &$errors) {
    for ($i = 0; $i < strlen($string); $i++) {
        if (ctype_upper($string[$i])) return true;
    }
    $errors[] = "La password deve contenere almeno una lettera maiuscola.";
    return false;
}

// 3. Numero
function checkNumber($string, &$errors) {
    for ($i = 0; $i < strlen($string); $i++) {
        if (is_numeric($string[$i])) return true;
    }
    $errors[] = "La password deve contenere almeno un numero.";
    return false;
}

// 4. Simboli validi: ! $ & ? @
function checkSymbol($string, &$errors) {
    $allowed = ['!', '$', '&', '?', '@'];
    $foundAllowed = false;

    for ($i = 0; $i < strlen($string); $i++) {
        $char = $string[$i];
        if (!ctype_alnum($char)) {
            if (in_array($char, $allowed)) {
                $foundAllowed = true;
            } else {
                $errors[] = "Il simbolo non è consentito: '$char' (consentiti solo !, \$, &, ?, @).";
            }
        }
    }

    if (!$foundAllowed) {
        $errors[] = "La password deve contenere almeno un simbolo tra !, \$, &, ?, @.";
        return false;
    }

    return true;
}

// 5. Nessuno spazio
function checkNoSpaces($string, &$errors) {
    if (strpos($string, ' ') !== false) {
        $errors[] = "La password non deve contenere spazi.";
        return false;
    }
    return true;
}

// Funzione principale
function validatePassword($password, &$errors) {
    $errors = [];

    $checks = [
        'checkLength',
        'checkUpperCase',
        'checkNumber',
        'checkSymbol',
        'checkNoSpaces'
    ];

    $allValid = true;
    foreach ($checks as $check) {
        if (!$check($password, $errors)) {
            $allValid = false;
        }
    }

    return $allValid;
}

// Ciclo finché la password non è valida
do {
    echo "Inserisci la tua password:\n";
    $password = readline();
    $errors = [];

    $isValid = validatePassword($password, $errors);

    if (!$isValid) {
        echo "{$RED}⚠️ Password non valida. Ecco gli errori rilevati:{$RESET}\n";
        foreach ($errors as $error) {
            echo "{$RED}- $error{$RESET}\n";
        }
    }
} while (!$isValid);

echo "{$GREEN}✅ Password valida!{$RESET}\n";

<?php
/** Règles de validation réutilisées partout (inscription, back office, espace agriculteur). */
class Validator
{
    public static function email(string $v): bool
    {
        return mb_strlen($v) <= 150 && filter_var($v, FILTER_VALIDATE_EMAIL) !== false;
    }

    /** 8 à 72 caractères, au moins une lettre et un chiffre. */
    public static function password(string $v): bool
    {
        return strlen($v) >= 8 && strlen($v) <= 72 && preg_match('/[A-Za-z]/', $v) && preg_match('/\d/', $v);
    }

    public static function phone(string $v): bool
    {
        return $v === '' || (bool) preg_match('/^[0-9+().\s-]{6,20}$/', $v);
    }

    public static function length(string $v, int $min, int $max): bool
    {
        $n = mb_strlen(trim($v));
        return $n >= $min && $n <= $max;
    }

    /** Renvoie un float si la valeur est un nombre dans l'intervalle, sinon null (virgule acceptée). */
    public static function decimal($v, float $min, float $max): ?float
    {
        $v = str_replace(',', '.', trim((string) $v));
        if ($v === '' || !is_numeric($v)) {
            return null;
        }
        $f = (float) $v;
        return ($f >= $min && $f <= $max) ? $f : null;
    }

    public static function date(string $v): bool
    {
        $d = DateTime::createFromFormat('Y-m-d', $v);
        return $d && $d->format('Y-m-d') === $v;
    }
}

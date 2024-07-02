<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Constantes utilisées dans le site
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Constants
{
    // Constantes
    const MIN_PWD_CAR = 8; // Nombre de caractères minimum pour le mot de passe
    const MAX_SURNAME_CAR = 15; // Nombre de caractères maximum pour le prénom
    const MAX_NAME_CAR = 10; // Nombre de caractères maximum pour le nom
    const MAX_DESC_CAR = 30; // Nombre de caractères maximum pour la description
    const IMG_SIZE = 3000000; // Taille max d'une image
    const SIZE_MIN = 0; // Taille min d'une image
    const SIZE_MAX = 60; // Taille max d'une paire
    const PRICE_MIN = 1; // Prix minimum d'une paire


    // Messages d'erreur
    const ERROR_MIN_PWD_CAR = "*Must be at least " . self::MIN_PWD_CAR . " caracters long";
    const NOT_EMPTY = "*Must not be empty";
    const SCHOOL_NOT_EXIST = "*Must select a school";
    const PWD_CAPS_SPE = "*Must contain 1 caps, digit and special caracter";
    const MUST_BE_IMG = "*Must be an image";
    const EMAIL = "*Must be a valid email";
    const ERROR_EMAIL_TAKEN = "*Email already taken";
    const MAX_CAR_SURNAME = "*Max " . self::MAX_SURNAME_CAR . " caracters";
    const MAX_CAR_NAME = "*Max " . self::MAX_NAME_CAR . " caracters";
    const SELECT_BRAND = "*Select a brand";
    const SELECT_MODEL = "*Select a model";
    const MUST_BE_NUMBER = "*Must be a number";
    const DESC_MAX_CAR = "*Max " . self::MAX_DESC_CAR . " caracters";
    const WRONG_EMAIL_PWD = "*Informations are incorrect or your account has been blocked";
    const ERROR_IMG_SIZE = "*Image is too big";
    const SIZE_MIN_MAX = "*Must be between " . self::SIZE_MIN . " and " . self::SIZE_MAX;
    const PRICE_MIN_MAX = "*can't be lower than " . self::PRICE_MIN . "$";
    const MEET_POINT_EXIST = "*Meet point already exist";
    const SCHOOL_EXIST = "*School already exist";

    /**
     * Empêche les injections SQL et XSS
     *
     * @param string $string // la chaine de caractère à sécuriser
     * @return string // la chaine de caractère sécurisée
     */
    static function AntiXSS($string): string
    {
        $string = htmlspecialchars($string, ENT_QUOTES);
        $string = strip_tags($string);
        $string = addslashes($string);

        return $string;
    }

    /**
     * Convertit l'image donnée en base 64
     *
     * @param array $file // Image à convertir
     * @return string // Chaine en base 64
     */
    static function ConvertImgTo64($file)
    {
        $src = "";

        if($file["name"] != ""){
            $data = file_get_contents($file['tmp_name']);
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);
            $src = 'data:' . $mime . ';base64,' . base64_encode($data);
        }
        return $src;
    }

}
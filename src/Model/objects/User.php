<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Objet User
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class User
{    // Constructeur de l'objet
    public function __construct(int|null $idUser = 0, string|null $nameUser = "", string|null $surnameUser = "", string|null $emailUser = "", string|null $pwdUser = "", int|null $idSchool = 0, string|null $imgUser = "", int|null $idRole = 1)
    {
        $this->idUser = $idUser;
        $this->nameUser = $nameUser;
        $this->surnameUser = $surnameUser;
        $this->emailUser = $emailUser;
        $this->pwdUser = $pwdUser;
        $this->idSchool = $idSchool;
        $this->imgUser = $imgUser;
        $this->idRole = $idRole;

    }

    /**
     * Id de le l'utilisateur
     *
     * @var integer
     */
    public $idUser;

    /**
     * Nom de l'utilisateur
     *
     * @var string
     */
    public $nameUser;

    /**
     * prénom de l'utilisateur
     *
     * @var string
     */
    public $surnameUser;

    /**
     * email de l'utilisateur
     *
     * @var string
     */
    public $emailUser;

    /**
     * mot de passe hashé de l'utilisateur
     *
     * @var string
     */
    public $pwdUser;

    /**
     * id de l'école de l'utilisateur
     *
     * @var integer
     */
    public $idSchool;

    /**
     * Photo de profil de l'utilisateur
     *
     * @var string
     */
    public $imgUser;

    /**
     * id du role de l'utilisateur
     *
     * @var integer
     */
    public $idRole;

}
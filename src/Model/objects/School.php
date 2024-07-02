<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Objet Ecole
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class School
{
    // Constructeur de l'objet
    public function __construct(int|null $idSchool = 0, string|null $nameSchool = "")
    {
        $this->idSchool = $idSchool;
        $this->nameSchool = $nameSchool;
    }

    /**
     * Id de le l'école
     *
     * @var integer
     */
    public $idSchool;

    /**
     * Nom de l'école
     *
     * @var string
     */
    public $nameSchool;
    
}
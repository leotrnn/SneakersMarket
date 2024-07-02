<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Objet Modèle
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class Modele
{
    // Constructeur de l'objet
    public function __construct(int|null $idModel = 0, string|null $nameModel = "")
    {
        $this->idModel = $idModel;
        $this->nameModel = $nameModel;
    }

    /**
     * Id du modèle
     *
     * @var integer
     */
    public $idModel;

    /**
     * Nom du modèle
     *
     * @var string
     */
    public $nameModel;
    
}
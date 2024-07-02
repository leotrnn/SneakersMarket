<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Objet Marque
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class Brand
{
    // Constructeur de l'objet
    public function __construct(int $idBrand = 0, string $nameBrand = "")
    {
        $this->idBrand = $idBrand;
        $this->nameBrand = $nameBrand;
    }

    /**
     * Id de le la marque
     *
     * @var integer
     */
    public $idBrand;

    /**
     * Nom de la marque
     *
     * @var string
     */
    public $nameBrand;
    
}
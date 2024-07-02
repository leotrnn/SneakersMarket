<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Objet Sneaker
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class Sneaker
{
    // Constructeur de l'objet
    public function __construct(int|null $idSneaker = 0, int|null $sizeSneaker = 0, float|null $priceSneaker = 0.0, string|null $imgSneaker = "", string|null $descriptionSneaker = "", string|null $nameSStatut = "", string|null $nameBrand = "", string|null $nameModel = "", string|null $nameVisibility = "")
    {
        $this->idSneaker = $idSneaker;
        $this->sizeSneaker = $sizeSneaker;
        $this->priceSneaker = $priceSneaker;
        $this->imgSneaker = $imgSneaker;
        $this->descriptionSneaker = $descriptionSneaker;
        $this->nameSStatut = $nameSStatut;
        $this->nameBrand = $nameBrand;
        $this->nameModel = $nameModel;
        $this->nameVisibility = $nameVisibility;

    }

    /**
     * Id de la sneaker
     *
     * @var integer
     */
    public $idSneaker;

    /**
     * taille de la sneaker
     *
     * @var integer
     */
    public $sizeSneaker;

    /**
     * prix de la sneaker
     *
     * @var float
     */
    public $priceSneaker;

    /**
     * image de la sneaker
     *
     * @var string
     */
    public $imgSneaker;

    /**
     * description de la sneaker
     *
     * @var string
     */
    public $descriptionSneaker;

    /**
     * nom du statut de la sneaker
     *
     * @var string
     */
    public $nameSStatut;
    /**
     * nom de la marque de la sneaker
     *
     * @var string
     */
    public $nameBrand;

    /**
     * nom du modele de la sneaker
     *
     * @var string
     */
    public $nameModel;

    /**
     * nom de la visibilité de la sneaker
     *
     * @var string
     */
    public $nameVisibility;

}
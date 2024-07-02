<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Objet User
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class ViewTransaction
{
    // Constructeur de l'objet
    public function __construct(int|null $idTransaction = 0, Sneaker|null $sneaker = new Sneaker(), User|null $acheteur = new User(), User|null $vendeur = new User(), string|null $nameStatut = "", MeetPoint|null $meetPoint = new MeetPoint())
    {
        $this->idTransaction = $idTransaction;
        $this->sneaker = $sneaker;
        $this->acheteur = $acheteur;
        $this->vendeur = $vendeur;
        $this->nameStatut = $nameStatut;
        $this->meetPoint = $meetPoint;

    }

    /**
     * Id de le la transaction
     *
     * @var integer
     */
    public $idTransaction;

    /**
     * Paire concernée
     *
     * @var Sneaker
     */
    public $sneaker;

    /**
     * Acheteur de la paire
     *
     * @var User
     */
    public $acheteur;

    /**
     * Vendeur de la paire
     *
     * @var User
     */
    public $vendeur;

    /**
     * statut de la transaction
     *
     * @var string
     */
    public $nameStatut;

    /**
     * point de rencontre
     *
     * @var string
     */
    public $meetPoint;

}
<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : TPI
Auteur : Léo Triano
Desc. : Site de Sneakers
Version : 1.0
Date : Mai 2024
Page : Objet Point de rendez vous
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class MeetPoint
{
    // Constructeur de l'objet
    public function __construct(int|null $idMeetPoint = 0, string|null $nameMeetPoint = "", string|null $adressMeetPoint = "", string|null $descriptionMeetPoint = "", DateTime|string|null $dateHourMeetPlace = new DateTime())
    {
        $this->idMeetPoint = $idMeetPoint;
        $this->nameMeetPoint = $nameMeetPoint;
        $this->adressMeetPoint = $adressMeetPoint;
        $this->descriptionMeetPoint = $descriptionMeetPoint;
        $this->dateHourMeetPlace = $dateHourMeetPlace;
    }

    /**
     * Id du point de rencontre
     *
     * @var integer
     */
    public $idMeetPoint;

    /**
     * Nom du point de rendez vous
     *
     * @var string
     */
    public $nameMeetPoint;

    /**
     * Adresse du point de rendez vous
     *
     * @var string
     */
    public $adressMeetPoint;

    /**
     * Description du point de rendez vous
     *
     * @var string
     */
    public $descriptionMeetPoint;

    /**
     * Date et heure du rendez vous
     *
     * @var DateTime
     */
    public $dateHourMeetPlace;
    
}
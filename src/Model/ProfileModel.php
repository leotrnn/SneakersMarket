<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modèle de la page profil
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Profile
{
    

    /**
     * Récupère toutes les écoles de la base de données
     *
     * @return array // tableau des écoles
     */
    function GetAllSchools() : array
    {

        $arr = array();

        $s = "SELECT * FROM SCHOOLS";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }



        while ($row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $u = new School($row["idSchool"], $row["nameSchool"]);
            array_push($arr, $u);
        }

        return $arr;
    }

    /**
     * Récupère l'utilisateur qui correspond à l'email donné
     *
     * @param string $email // l'email à vérifier
     * @return User|false // Retourne l'utilisateur s'il existe, false s'il n'existe pas
     */
    function GetUserByEmail(string $email): User|false
    {
        $s = "SELECT * FROM USERS WHERE emailUser = :email";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':email' => $email));

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User($row["idUser"], $row["nameUser"], $row["surnameUser"], $row["emailUser"], $row["pwdUser"], $row["idSchool"], $row["imgUser"], $row["idRole"]);
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        return false;
    }

    /**
     * Vérifie si l'email donné est déjà utilisé par un utilisateur
     *
     * @param string $email // email à vérifier
     * @return boolean // oui ou non
     */
    function CheckEmailAlreadyUsed(string $email): bool
    {
        $email = self::GetUserByEmail($email);

        return ($email !== false);
    }

    /**
     * Vérifie si l'école donnée existe
     *
     * @param integer $idSchool // l'id de l'école à vérifier
     * @return boolean // oui ou non
     */
    function DoesSchoolExist(int $idSchool): bool
    {
        $s = "SELECT * FROM SCHOOLS WHERE idSchool = :idSchool";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->bindParam(':idSchool', $idSchool);
            $statement->execute();

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            } else {
                // School not found
                return false;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Vérifie si le mot de passe correspond avec le mot de passe hashé dans la base
     *
     * @param User $user // utilisateur à vérifier
     * @return boolean
     */
    function CheckPassword(string $email, $password): bool
    {
        $Hashedpassword = self::GetUserByEmail($email)->pwdUser;

        return password_verify($password, $Hashedpassword);
    }

    /**
     * Vérifie les informations de modification de compte
     *
     * @param User $user // Utilisateur à vérifie
     * @param integer $idSchool // l'id de l'école
     * @param array $img // la potentielle nouvelle image de l'utilisateur
     * @return array // Tableau des potentielles erreurs
     */
    function ErrorMessagesRegister(User $user, int $idSchool, array $img): array
    {
        $expressionEmail = "/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/"; // Reprise d'un ancien projet, trouvée à l'époque sur internet


        // Variables
        $errorMessages = [];


        if ($img["type"] != "image/png" && $img["type"] != "image/jpeg" && $img["type"] != "image/jpg" && $img["name"] != "") {
            $errorMessages["errorImg"] = Constants::MUST_BE_IMG;
        }
        if($img["size"] > Constants::IMG_SIZE){
            $errorMessages["errorImg"] = Constants::ERROR_IMG_SIZE;
        }

        if(strlen($user->nameUser) > 15){
            $errorMessages["errorName"] = Constants::MAX_CAR_NAME;
        }

        // Erreur si le nom est vide
        if ($user->nameUser == "") {
            $errorMessages["errorName"] = Constants::NOT_EMPTY;
        }

        if(strlen($user->surnameUser) > 10){
            $errorMessages["errorSurname"] = Constants::MAX_CAR_SURNAME;
        }
      

        // Erreur si le prénom est vide
        if ($user->surnameUser == "") {
            $errorMessages["errorSurname"] = Constants::NOT_EMPTY;
        }

        
        if(!preg_match($expressionEmail, $user->emailUser)){
            $errorMessages["errorEmailRegister"] = Constants::EMAIL;
        }

        // Erreur si l'email est vide
        if ($user->emailUser == "") {
            $errorMessages["errorEmailRegister"] = Constants::NOT_EMPTY;
        }


        // Erreur si le mot de passe est vide
        if (!self::DoesSchoolExist($idSchool)) {
            $errorMessages["errrorSchoolRegister"] = Constants::SCHOOL_NOT_EXIST;
        }

        return $errorMessages;
    }

    /**
     * Récupère l'école en fonction de son id donné
     *
     * @param int $idSchool // l'id de l'école
     * @return School // L'école récupérée
     */
    function GetSchoolFromId(int $idSchool): School
    {

        $s = "SELECT * FROM SCHOOLS WHERE idSchool = :idSchool";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSchool', $idSchool, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);

        $u = new School($row["idSchool"], $row["nameSchool"]);

        return $u;
    }

    /**
     * Met à jour le profil de l'utilisateur grâce aux nouvelles informations données
     *
     * @param User $user // Les nouvelles informations de l'utilisateur
     * @param array $img // La potentielle nouvelle image
     * @return boolean // L'opération a réussi ou non
     */
    function UpdateProfile(User $user, array  $img) : bool
    {
        try {
            if($img["name"] == ""){
                $img = $_SESSION["imgUser"];
            }
            else{
                $img = Constants::ConvertImgTo64($img);
            }
            $nameUser = Constants::AntiXSS($user->nameUser);
            $surnameUser = Constants::AntiXSS($user->surnameUser);
            $emailUser = Constants::AntiXSS($user->emailUser);
            $idSchool = Constants::AntiXSS($user->idSchool);

            $s = "UPDATE USERS SET nameUser = :nameUser, surnameUser = :surnameUser, emailUser = :emailUser, idSchool = :idSchool, imgUser = :imgUtilisateur
             WHERE idUser = :idUser";
            $statement = Database::prepare($s);

            $statement->bindParam(':nameUser', $nameUser);
            $statement->bindParam(':surnameUser', $surnameUser);
            $statement->bindParam(':emailUser', $emailUser);
            $statement->bindParam(':idSchool', $idSchool, PDO::PARAM_INT);
            $statement->bindParam(':imgUtilisateur', $img);
            $statement->bindParam(':idUser', $user->idUser);

            $statement->execute();


            self::ValuesSession(new User($_SESSION['idUser'], $nameUser, $surnameUser, $emailUser, "", $idSchool, $img, $_SESSION['idRole']));

            return true;


        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }

    /**
     * Met à jour les valeurs de la session après la mise à jour du profil
     *
     * @param User $user // Les informations à changer
     * @return void
     */
    function ValuesSession(User $user): void
    {
        $_SESSION["idUser"] = $user->idUser;
        $_SESSION["nameUser"] = $user->nameUser;
        $_SESSION["surnameUser"] = $user->surnameUser;
        $_SESSION["emailUser"] = $user->emailUser;
        $_SESSION["idSchool"] = $user->idSchool;
        $_SESSION["imgUser"] = $user->imgUser;
        $_SESSION['idRole'] = $user->idRole;
        $_SESSION["customMessage"] = "Welcome " . $user->surnameUser . " !";
    }

    function DeleteProfilePicture(){
        try {

            $s = "UPDATE USERS SET imgUser = NULL WHERE idUser = :idUser";
            $statement = Database::prepare($s);

            $statement->bindParam(':idUser', $_SESSION['idUser']);

            $statement->execute();

            $_SESSION['imgUser'] = "";
            return true;


        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }
}
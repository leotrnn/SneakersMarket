<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modèle de la page modify user
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class ModifyUser
{

    /**
     * vérifie si l'utilisateur existe avec son id
     *
     * @param integer $idUser // id de l'utilisateur à vérifier
     * @return boolean // il existe ou non
     */
    function DoesUserExist(int $idUser): bool
    {
        $s = "SELECT * FROM USERS WHERE idUser = :idUser";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':idUser' => $idUser));

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        return false;
    }

    /**
     * Récupère toutes les écoles dans la base de données
     *
     * @return array // le tableau avec toutes les écoles
     */
    function GetAllSchools(): array
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
     * Récupère l'utilisateur avec l'id donné
     *
     * @param integer $idUser // l'id à vérifier
     * @return User|false // L'utilisateur s'il existe, false s'il existe pas
     */
    function GetUserById(int $idUser): User|false
    {
        $s = "SELECT * FROM USERS WHERE idUser = :idUser";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':idUser' => $idUser));

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
     * Récupère l'utilisateur avec l'email donné
     *
     * @param string $emailUser // l'email à vérifier
     * @return User|false // L'utilisateur s'il existe, false s'il existe pas
     */
    function GetUserByEmail(string $emailUser): User|false
    {
        $s = "SELECT * FROM USERS WHERE emailUser = :emailUser";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':emailUser' => $emailUser));

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
     * Vérifie si l'email a déjà été utilisé grâce à l'id de l'utilisateur
     *
     * @param integer $id // l'id à vérifier
     * @return boolean // Oui ou non
     */
    function CheckEmailAlreadyUsed(int $id): bool
    {
        $id = self::GetUserById($id);

        return ($id !== false);
    }

    /**
     * Vérifie si l'école existe grâce à l'id donné
     *
     * @param integer $idSchool // l'id de l'école à vérifier
     * @return boolean // Oui ou non
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
     * @return boolean // oui ou non
     */
    function CheckPassword(string $email, $password): bool
    {
        $Hashedpassword = self::GetUserById($email)->pwdUser;

        return password_verify($password, $Hashedpassword);
    }

    /**
     * Vérifie si les informations données sont conformes
     *
     * @param User $user // informations de l'utilisateur à vérifier
     * @param integer $idSchool // id de l'école
     * @param array $img // potentielle nouvelle image
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
        if ($img["size"] > Constants::IMG_SIZE) {
            $errorMessages["errorImg"] = Constants::ERROR_IMG_SIZE;
        }

        // Erreur si le nom est vide
        if ($user->nameUser == "") {
            $errorMessages["errorName"] = Constants::NOT_EMPTY;
        }

        // Erreur si le prénom est vide
        if ($user->surnameUser == "") {
            $errorMessages["errorSurname"] = Constants::NOT_EMPTY;
        }

        if (!preg_match($expressionEmail, $user->emailUser)) {
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
     * Récupère l'école grâce à son id
     *
     * @param integer $idSchool // id de l'école à vérifier
     * @return School // l'école
     */
    function GetSchoolFromId(int $idSchool): School
    {

        $s = "SELECT * FROM SCHOOLS WHERE idSchool = :idSchool";
        $statement = Database::prepare($s, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try {
            $statement->bindParam(':idSchool', $idSchool);
            $statement->execute();
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);

        $u = new School($row["idSchool"], $row["nameSchool"]);

        return $u;
    }

    /**
     * Met à jour le profil de l'utilisateur
     *
     * @param User $user // Nouvelles informations de l'utilisateur
     * @param array $img // Potentielle nouvelle image de l'utilisateur
     * @return boolean // L'opération a réussi ou non
     */
    function UpdateProfile(User $user, array $img): bool
    {
        try {
            if ($img["name"] == "") {
                $img = self::GetUserById($user->idUser)->imgUser;
            } else {
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
            return true;


        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
            return false;
        }
    }
}
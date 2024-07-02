<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
Projet : SneakersMarket (TPI)
Auteur : Léo Triano
Desc. : Site d'achat-revente de sneakers
Version : 1.0
Date : Mai 2024
Page : Modele de la page login/register (auth)
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Auth
{
    /**
     * Vérifie les données envoyées en POST du register
     *  et retourne un tableau d'erreur en fonction de s'il y en a ou pas
     *
     * @param User $user // Utilisateur à vérifier
     * @param integer $idSchool // école sélectionnée
     * @return array // Tableau d'erreurs
     */
    function ErrorMessagesRegister(User $user, int $idSchool, $img): array
    {
        // Variables
        $errorMessages = [];

        // Expressions régulières
        $expressionCarSpe = "/[!@#$%^&*()_+{}\[\]:;<>,.?~\\\\\/\-=\"\'\|\s]/"; // Reprise d'un ancien projet, trouvée à l'époque sur internet
        $expressionEmail = "/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}/"; // Reprise d'un ancien projet, trouvée à l'époque sur internet
        $expressionCaps = "/[A-Z]/"; // écrite pour ce projet
        $expressionDigit = "/[0-9]/"; // écrite pour ce projet

        // Erreur si l'email est déjà utilisé
        if (self::CheckEmailAlreadyUsed($user->emailUser)) {
            $errorMessages["errorEmailRegister"] = Constants::ERROR_EMAIL_TAKEN;
        }

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

        if(strlen($user->nameUser) > Constants::MAX_NAME_CAR){
            $errorMessages["errorName"] = Constants::MAX_CAR_NAME;
        }

        // Erreur si le prénom est vide
        if ($user->surnameUser == "") {
            $errorMessages["errorSurname"] = Constants::NOT_EMPTY;
        }

        if(strlen($user->surnameUser) > Constants::MAX_SURNAME_CAR){
            $errorMessages["errorSurname"] = Constants::MAX_CAR_SURNAME;
        }

        if (!preg_match($expressionEmail, $user->emailUser)) {
            $errorMessages["errorEmailRegister"] = Constants::EMAIL;
        }

        // Erreur si l'email est vide
        if ($user->emailUser == "") {
            $errorMessages["errorEmailRegister"] = Constants::NOT_EMPTY;
        }

        // Erreur si le mot de passe ne contient pas de cactère spécial, de majuscule ou de chiffre
        if (!preg_match($expressionCarSpe, $user->pwdUser) || !preg_match($expressionCaps, $user->pwdUser) || !preg_match($expressionDigit, $user->pwdUser)) {
            $errorMessages["errorPasswordRegister"] = Constants::PWD_CAPS_SPE;
        }

        // Erreur si le nom ne convient pas à la plage de nombre de caractères donné
        if (strlen($user->pwdUser) < Constants::MIN_PWD_CAR) {
            $errorMessages["errorPasswordRegister"] = Constants::ERROR_MIN_PWD_CAR;
        }

        // Erreur si le mot de passe est vide
        if (!self::DoesSchoolExist($idSchool)) {
            $errorMessages["errrorSchoolRegister"] = Constants::SCHOOL_NOT_EXIST;
        }

        // Erreur si le mot de passe est vide
        if ($user->pwdUser == "") {
            $errorMessages["errorPasswordRegister"] = Constants::NOT_EMPTY;
        }

        return $errorMessages;
    }

    /**
     * Vérifie si l'utilisateur actuel n'est pas bloqué ou non
     *
     * @return boolean // Oui ou non
     */
    function IsUserNotBlocked($emailUser) : bool
    {
        $s = "SELECT * FROM USERS WHERE emailUser = :emailUser AND idUStatut = 1";
        $statement = Database::prepare($s, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        try {
            $statement->execute(array(':emailUser' => $emailUser));

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Problème de lecture de la base de données: ' . $e->getMessage();
            return false;
        }

        return false;
    }

    /**
     *  Vérifie les données envoyées en POST du login
     *  et retourne un tableau d'erreur en fonction de s'il y en a ou pas
     *
     * @param User $user // Utilisateur à vérifier
     * @return array // Tableau des potentielles erreurs
     */
    function ErrorMessagesLogin(User $user): array
    {
        $errorMessages = [];

        // Erreur si l'email n'existe pas
        if (!self::CheckEmailAlreadyUsed($user->emailUser) || !self::IsUserNotBlocked($user->emailUser)) {
            $errorMessages["errorLogin"] = Constants::WRONG_EMAIL_PWD;
        } else {
            if (!self::CheckPassword($user->emailUser, $user->pwdUser)) {
                $errorMessages["errorLogin"] = Constants::WRONG_EMAIL_PWD;
            }
        }

        return $errorMessages;
    }

    /**
     * récupère l'utilisateur avec l'email correspondant
     *
     * @param string $email // email à vérifier
     * @return User|false // Retourne l'utilisateur s'il y en a un, false si non
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
     * Vérifie si l'email entré correspond déjà à un utilisateur dans la base, renvoie true ou false en fonction
     *
     * @param string $email email à vérifier
     * @return boolean
     */
    function CheckEmailAlreadyUsed(string $email): bool
    {
        $email = self::GetUserByEmail($email);

        return ($email !== false);
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
     * Insère dans la base les données de l'utilisateur
     *
     * @param User $user // L'utilisateur à insérer
     * @param integer $idSchool // l'id de l'école choisie
     * @return void
     */
    function Register(User $user, int $idSchool, $img): void
    {
        try {
            // Sécurisation des données
            $name = Constants::AntiXSS($user->nameUser);
            $surname = Constants::AntiXSS($user->surnameUser);
            $email = Constants::AntiXSS($user->emailUser);
            $password = Constants::AntiXSS($user->pwdUser);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $idSchool = Constants::AntiXSS($idSchool);
            if ($img["name"] != "") {
                $img = Constants::ConvertImgTo64($img);
            } else {
                $img = "";
            }

            $s = "INSERT INTO USERS(nameUser, surnameUser, emailUser, pwdUser, idSchool, imgUser) VALUES(:name, :surname, :email, :password, :idSchool, :img)";
            $statement = Database::prepare($s);

            $statement->bindParam(':name', $name);
            $statement->bindParam(':surname', $surname);
            $statement->bindParam(':email', $email);
            $statement->bindParam('password', $password);
            $statement->bindParam('idSchool', $idSchool);
            $statement->bindParam('img', $img);

            $statement->execute();

        } catch (PDOException $e) {
            echo 'Problème d\'insertion en base de données: ' . $e->getMessage();
        }
    }

    /**
     * Connecte l'utilisateur
     *
     * @param User $user // L'utilisateur à connecter
     * @return void
     */
    function Login($email): void
    {
        $user = self::GetUserByEmail($email);

        if ($user !== false) {
            self::ValuesSession(new User($user->idUser, $user->nameUser, $user->surnameUser, $user->emailUser, "", $user->idSchool, $user->imgUser, $user->idRole));
        }
    }

    /**
     * Rentre les données peu importantes de l'utilisateur en session
     *
     * @param User $user
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

    /**
     * Vérifie si l'école sélectionnée est en base
     *
     * @param integer $idSchool // id à vérifier
     * @return bool // Vrai ou faux
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
     * Récupère toutes les écoles de la base
     *
     * @return array // Tableau des écoles
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

}
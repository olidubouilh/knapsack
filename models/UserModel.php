<?php
//IMPORTANT: C"EST UN EXEMPLE DE CODE
require_once 'src/class/ModelInterface.php';
require_once 'src/class/User.php';
require_once 'models/AdModel.php';

class UserModel
{

    // La propriété pourrait être déclarée hors constructeur
    // private PDO $pdo

    // Ici la propriété $pdo est déclarée dans le constructeur directement
    public function __construct(private PDO $pdo) {}

    
    
    
    // public function selectAll() : null|array {
        
    //     $users = [];

    //     try{

    //         // $this->pdo-> car $pdo est une propriété de l'objet
    //         $stm = $this->pdo->prepare(query: "#######`#######");
    
    //         $stm->execute();
    
    //         $data = $stm->fetchAll(PDO::FETCH_ASSOC);

    //         if (! empty($data)) {

    //             foreach ($data as $row) {
    //                 if ($row['role'] != '1'){
    //                     $users[] = new User(
    //                         $row['id'], 
    //                         $row['name'], 
    //                         $row['email'], 
    //                         $row['role'], 
    //                         $row['password'],
    //                         $row['active']
    //                         );
    //                 }
                    

    //             }

    //             return $users;

    //         }
            
    //         return null;
            
    //     } catch (PDOException $e) {
    
    //         throw new PDOException($e->getMessage(), $e->getCode());
            
    //     }

    // }

    public function selectById(int $id) {
        
        try{
            $stm = $this->pdo->prepare('##########');
    
            $stm->bindValue(":id", $id, PDO::PARAM_INT);
            
            $stm->execute();
    
            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if(! empty($data)) {

                return new User(
                    $id, 
                    $data['name'], 
                    $data['email'], 
                    $data['role'], 
                    $data['password'],
                    $data['active']
                    );

            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }  

    }

    public function selectByEmail(string $email) : null|User {

        try{
            $stm = $this->pdo->prepare('SELECT id, name, role, password, active FROM user WHERE email=:email');
    
            $stm->bindValue(":email", $email, PDO::PARAM_STR);
            
            $stm->execute();
    
            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if(! empty($data)) {

                return new User(
                    $data['id'], 
                    $data['name'], 
                    $email, 
                    $data['password'], 
                    $data['role'],
                    $data['active']
                    );

            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }  

    }
    public function verifyEmail(string $email)  {

        try{
            $stm = $this->pdo->prepare('SELECT * FROM user WHERE email=:email');
    
            $stm->bindValue(":email", $email, PDO::PARAM_STR);
            
            $stm->execute();
    
            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if(! empty($data)) {

                return true;

            }
            
            return false;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }  

    }
    public function verifyPassword(string $password, string $email) : bool {
        if ($this->verifyEmail($email)) {
            try {
                
        
                $data = $this->selectByEmail($email);
        
                return password_verify($password, $data->getPassword());
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), $e->getCode());
            }
        }
        else {
            return false;
        }
    }

    function insertOne(array $data) : int|false
    {
        try{
            $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);
            $stm = $this->pdo->prepare('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)');
            
            $stm->bindValue(":name", $data["name"], PDO::PARAM_STR);
            $stm->bindValue(":email", $data["email"], PDO::PARAM_STR);
            $stm->bindValue(":password", $hashedPassword, PDO::PARAM_STR);

            
            if ($stm->execute()) {

                return $this->pdo->lastInsertId();
                
            }
            
            return false;

        } catch (PDOException $e) {
                    
            throw new PDOException($e->getMessage(), $e->getCode());

        }    


    }
    public function updateActive(int $id, $active) : bool {
        try {
            $adModel = new AdModel($this->pdo);
            $adModel->updateUserActiveAd($id, $active);
            $stm = $this->pdo->prepare('UPDATE user SET active=:active WHERE id=:id');

            $stm->bindValue(":id", $id, PDO::PARAM_INT);
            $stm->bindValue(":active", $active, PDO::PARAM_STR);

            $stm->execute();
            return true;
        }
        catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}


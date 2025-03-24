<?php
//IMPORTANT: C"EST UN EXEMPLE DE CODE
require_once 'src/class/User.php';


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
                    $data['idJoueurs'], 
                    $data['nomJoueur'],
                    $data['prenomJoueur'],
                    $data['alias'],
                    $data['mPasse'], 
                    $data['montant'],
                    $data['dexterite'],
                    $data['pvJoueur'],
                    $data['PoidsMaximal']
                );
            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
        }  

    }
    public function verifierAlias(string $alias) : bool {
        try{
            $stm = $this->pdo->prepare('call verifierAlias(alias =:alias)');
            $stm->bindValue(":alias", $alias, PDO::PARAM_STR);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                return true;
            }
            return false;
        } catch (PDOException $e) {

            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function selectByAlias(string $alias, string $password) : null|User {

        try{
           
            $stm = $this->pdo->prepare('select * from Joueurs where alias = :alias');
            $stm->bindValue(":alias", $alias, PDO::PARAM_STR);
            $stm->execute();
            
            $data = $stm->fetch(PDO::FETCH_ASSOC);
    
            if (!empty($data)) {
                
                $hashedPassword = hash('sha512', $password);
                
                if ($hashedPassword === $data['mPasse']) {
                    return new User(
                        $data['idJoueurs'], 
                        $data['nomJoueur'],
                        $data['prenomJoueur'],
                        $data['alias'],
                        $data['mPasse'], 
                        $data['montant'],
                        $data['dexterite'],
                        $data['pvJoueur'],
                        $data['PoidsMaximal'] 
                    );
                }
                return null;
            }
            else {
                return null;
            }
            
        } catch (PDOException $e) {
            var_dump($e->getMessage());
    
            throw new PDOException($e->getMessage(), $e->getCode());
            
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
   
}


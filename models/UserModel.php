<?php
//IMPORTANT: C"EST UN EXEMPLE DE CODE
require_once 'src/class/User.php';


class UserModel
{

    public function __construct(private PDO $pdo) {}

    
    public function selectInfoJoueur(string $alias) {
        
        try{
            $stm = $this->pdo->prepare('select * from Joueurs where alias = :alias');
    
            $stm->bindValue(":alias", $alias, PDO::PARAM_STR);
            
            $stm->execute();
    
            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if(! empty($data)) {

                return new User(
                    id: $data['idJoueurs'], 
                    nom: $data['nomJoueur'],
                    prenom: $data['prenomJoueur'],
                    alias: $data['alias'],
                    password: $data['mPasse'], 
                    argent: $data['montant'],
                    dex: $data['dexterite'],
                    pv: $data['pvJoueur'],
                    poids: $data['PoidsMaximal'],
                    isAdmin: $data['isAdmin'],

                );
            }
            
            return null;
            
        } catch (PDOException $e) {
    
            throw $e;
            
        }  

    }
    public function poidSac(string $id) : string|null{
        try{
            $stm = $this->pdo->prepare('call poidSac(:id)');
            $stm->bindValue(":id", $id, PDO::PARAM_STR);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                return $data['poids_total'];
            }
            return 0;
        } catch (PDOException $e) {

            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    public function verifierAlias(string $alias) : bool {
        try{
            $stm = $this->pdo->prepare('call verifierAlias(:alias)');
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
                        $data['PoidsMaximal'],
                        isAdmin: $data['isAdmin'],
                    );
                }
                return null;
            }
            else {
                return null;
            }
            
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage() . " (SQLSTATE: {$e->getCode()})", 0);
            
        }  

    }

    function insertOne(array $data) : void
    {
        try{
            
            $stm = $this->pdo->prepare('CALL AjouterJoueur(:alias, :nomJoueur, :prenomJoueur, :password)');  
            
            $stm->bindValue(":alias", $data["alias"], PDO::PARAM_STR);
            $stm->bindValue(":nomJoueur", $data["nomJoueur"], PDO::PARAM_STR);
            $stm->bindValue(":prenomJoueur", $data["prenomJoueur"], PDO::PARAM_STR);
            $stm->bindValue(":password", $data['password'], PDO::PARAM_STR);
            $stm->execute();
            

        } catch (PDOException $e) {
                    
            throw new PDOException($e->getMessage(), (int)$e->getCode());

        }    


    }
   
}


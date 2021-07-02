<?php

class Account
{
    private $id;
    private $email;
    private $authenticated;
    private $role;
    private $first_name;
    private $last_name;

    public function __contruct()
    {
        $this->id = NULL;
        $this->email = NULL;
        $this->authenticated = FALSE;
        $this->first_name = NULL;
        $this->last_name = NUll;
    }

    public function __destruct() {}

    /* Getter function for the $authenticated variable */
    public function IsAuthenticated()
    {
        return $this->authenticated;
    }

    public function GetID(): int
    {
        return $this->id;
    }

    public function GetEmail(): string
    {
        return $this->email;
    }
    public function IsEmailValid(string $email): bool
    {
        $valid = TRUE;
       

        return $valid;
    }

    public function IsPasswdValid(string $passwd): bool
    {
        $valid = TRUE;
        $len = mb_strlen($passwd);

        if(($len < 8) || ($len > 16))
        {
            $valid = FALSE;
        }

        return $valid;
    }

    public function GetIdFromEmail(string $email): ?int
    {
        global $pdo;
        if(!$this->IsEmailValid($email))
        {
            throw new Exception('Invalid email address');
        }
        $id = NULL;
        $query = 'SELECT user_id FROM users WHERE (email = :email)';
        $values = array(':email' => $email);

        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e)
        {
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        if(is_array($row))
        {
            $id = intval($row['user_id'],10);
        }

        return $id;
    }

    public function IsFirstNameValid($first_name)
    {
        $valid = TRUE;
        $len = mb_strlen($first_name);


        return $valid;
    }

    public function IsLastNameValid($last_name)
    {
        $valid = TRUE;
        $len = mb_strlen($last_name);

        
        return $valid;
    }
    public function AddAccount(string $email, string $passwd, string $passwd2, string $first_name, string $last_name, string $role): array
    {
        global $pdo;
        $e = trim($email);
        $p1 = trim($passwd);
        $p2 = trim($passwd2);
        $fn = trim($first_name);
        $ln = trim($last_name);
        $r = trim($role);

        $errors = array();

        if(empty($e) || !$this->IsEmailValid($e))
        {
            array_push($errors, 'Invalid email');
        }
        if(empty($p1) || !$this->IsPasswdValid($p1))
        {
            array_push($errors,'Invalid password');
        }
        if(empty($p2) || !$this->IsPasswdValid($p2))
        {
            array_push($errors, 'Invalid password2');
        }
        if($p1 != $p2)
        {
            array_push($errors, 'Passwords do not match');
        }
        if(!is_null($this->GetIdFromEmail($e)))
        {
            array_push($errors,'Email address already in use.');
        }

        if(!empty($errors))
        {
            $errors;
        }
        else
        {
            $query = 'INSERT INTO users (email,pass,first_name,last_name,user_type)
                VALUES (:email,:passwd,:first_name,:last_name,:user_role)';
            $hash = password_hash($passwd, PASSWORD_DEFAULT);
            $values = array(':email'=> $e, 
                ':passwd'=>$hash,
                ':first_name'=>$fn,
                ':last_name'=>$ln,
                ':user_role'=>$r);

            try
            {
                $res = $pdo->prepare($query);
                $res->execute($values);
            }
            catch(PDOException $e)
            {
                throw new Exception('Database error');
            }
            return array ($errors, $pdo->lastInsertId());
        }
        return array($errors, NULL);
        
    }

    public function IsIdValid(int $id): bool
    {
        $valid = TRUE;

        if(($id < 1) || ($id > 10000000))
        {
            $valid = FALSE;
        }

        return $valid;
    }

    public function EditAccount(int $id, string $email, string $passwd) // add bool $enabled) 
    {
        global $pdo;

        $email = trim($email);
        $passwd = trim($passwd);

        if(!$this->IsIdValid($id))
        {
            throw new Exception('Invalid account Id');
        }

        if(!$this->IsEmailValid($email))
        {
            throw new Exception('Invalid email address');
        }

        if(!$this->IsPasswdValid($passwd))
        {
            throw new Exception('Invalid password');
        }

        $idFromEmail = $this->GetIdFromEmail($email);

        if(!is_null($idFromEmail) && ($idFromEmail != $id))
        {
            throw new Exception('Email address already in use');
        }
// add account_enabled = :enabled
        $query = 'UPDATE users SET email = :email, pass = :passwd WHERE user_id =:id';
        $hash = password_hash($passwd, PASSWORD_DEFAULT);
        //$intEnabled = $enabled ? 1 : 0;
        $values = array(':email' => $email, ':passwd' => $hash, ':id' => $id);
// ':enabled' => $intEnabled,

        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e)
        {
            throw new Exception('Database query error');
        }
    }

    public function DeleteAccount(int $id)
    {
        global $pdo;

        if(!$this->IsIdValid($id))
        {
            throw new Exception('Invalid account Id');
        }

        $query = 'DELETE FROM users WHERE user_id = :id';
        $values = array(':id' => $id);

        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch (PDOException $e)
        {
            throw new Exception('Database query error');
        }
    }

    public function AddUserDetailsToSession()
    {
        global $pdo;

        if(session_status() == PHP_SESSION_ACTIVE)
        {
            $query = 'SELECT * FROM users WHERE user_id = :id';
            $values = array(':id' => $this->id);
            //ADU1
            try
            {
                $res = $pdo->prepare($query);
                $res->execute($values);
            }
            catch(PDOException $e)
            {
                throw new Exception('Database query error AUD1');
            }

            $row = $res->fetch(PDO::FETCH_ASSOC);
            if($this->id == $row['user_id'])
            {
                $_SESSION['user_id'] = $this->id;
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['user_type'] = $row['user_type'];
            }
            
        }
    }

    public function RegisterLoginSession()
    {
        global $pdo;
        
        if(session_status() == PHP_SESSION_ACTIVE)
        {
            $query = 'REPLACE INTO login_sessions (session_id, user_id, login_time)
                VALUES (:sid, :userId, NOW())';
            $values = array(':sid' => session_id(), ':userId' => $this->id);

            try
            {
                $res = $pdo->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
                throw new Exception('Database query error');
            }

        }
    }

    public function SessionLogin(): bool
    {
        global $pdo;

        if(session_status() == PHP_SESSION_ACTIVE)
        {
            $query = 'SELECT * FROM login_sessions, users WHERE (login_sessions.session_id = :sid)' .
            'AND (login_sessions.login_time >= (NOW() - INTERVAL 7 DAY)) AND (login_sessions.user_id = users.user_id)';
// add  'AND (accounts.account_enabled = 1)'

            $values = array(':sid' => session_id());

            try
            {
                $res = $pdo->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
                throw new Exception('Database query error');
            }

            $row = $res->fetch(PDO::FETCH_ASSOC);

            if(is_array($row))
            {
                $this->id = intval($row['user_id'],10);
                $this->email = $row['email'];
                $this->authenticated = TRUE;

                return TRUE;
            }
        }
        return FALSE;
    }

    public function Login(string $email, string $passwd): bool
    {
        global $pdo;

        $email = trim($email);
        $passwd = trim($passwd);

        if(!$this->IsEmailValid($email))
        {
            return FALSE;
        }

        if(!$this->IsPasswdValid($passwd))
        {
            return FALSE;
        }

        $query = 'SELECT * FROM users WHERE (email = :email)';
        //add  AND (account_enabled = 1)
        $values = array(':email' => $email);

        try
        {
            $res = $pdo->prepare($query);
            $res->execute($values);
        }
        catch(PDOException $e)
        {
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        if(is_array($row))
        {
            if(password_verify($passwd, $row['pass']))
            {
                $this->id = intval($row['user_id'], 10);
                $this->email = $email;
                $this->authenticated = TRUE;

                $this->RegisterLoginSession();
                $this->AddUserDetailsToSession();
                
                return TRUE;
            }
        }

        return FALSE;
    }

    

    public function LogOut()
    {
        global $pdo;

        if(is_null($this->id))
        {
            return;
        }

        $this->id = NULL;
        $this->email = NULL;
        $this->authenticated = FALSE;

        if(session_status() == PHP_SESSION_ACTIVE)
        {
            $query = 'DELETE FROM login_sessions WHERE (session_id = :sid)';
            $values = array(':sid'=>session_id());

            try
            {
                $res=$pdo->prepare($query);
                $res->execute($values);
            }
            catch (PDOException $e)
            {
                throw new Exception('Database query error');
            }
        }
    }
    
}
    
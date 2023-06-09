<?php
class Login
{
    // Error is empty
    private $error = "";
    // Evaluating Data
    public function evaluate($data)
    {
        // addslashes avoid any injections
        $email = addslashes($data['email']);
        $password = addslashes($data['password']);

        // Check Email in the Database
        // LIMIT 1 ensures that inputted Email wont use other similar Email
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

        // Creates new Database
        // Which have read and save
        $DB = new Database();
        // Reads Database
        $result = $DB->read($query);

        // Checks MYSQL Table if user input is Correct
        if($result)
        {
            // Reads 1 row ONLY
            $row = $result[0];

            // If row matches input password
            if($password == $row['password'])
            {
                // Create SESSION Data
                // SESSION Register user -> User no longer need to login again
                $_SESSION['userid'] = $row['userid'];

            // If row doesn't match input password
            }else
            {
                // Output
                $this->error .= "Wrong Password<br>";
            }

        }else
        {
            // If Email is wrong
            $this->error .= "No such email was found<br>";
        }
        // If Inputted Email/Password is wrong return to Function
        return $this->error;
    }

    public function change_pass($data, $id)
    {
        $query = "SELECT userid FROM users WHERE userid = '$id' limit 1";
        
        $password = addslashes($data['password']);
        $password = addslashes($data['newpassword']);

        $DB = new Database();
        $result = $DB->read($query);

        $row = $result[0];
        if($result)
        {
            if($password == $row['password'])
            {
                $newpassword = $data['newpassword'];
                $query = "UPDATE users SET password = '$newpassword' WHERE userid = '$id' LIMIT 1";
                $DB = new Database();
                $DB->save($query);
            }else
            {
                $this->error .= "Wrong Password<br>";
            }
        }else{
            return false;
        }
    }

    public function check_login($id)
    {
        $query = "SELECT userid FROM users WHERE userid = '$id' limit 1";

        $DB = new Database();
        $result = $DB->read($query);

        if($result)
        {
            return true;
        }
        return false;
    }
}
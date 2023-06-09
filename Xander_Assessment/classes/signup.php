<?php

class Signup
{   
    // Error is empty
    private $error = "";
    // Evaluating Data
    public function evaluate($data)
    {
        // Sets data/key values
        foreach ($data as $key => $value) {
            // Finds data/key if they have empty Value
            if(empty($value))
            {
                $this->error = $this->error . $key . " is empty!<br>";
            }

            // Checks if input Email input matches
            if ($key == "email")
            {
                // Checks data/key value of Email 
                // If Value is incorrect/invalid
                if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)) {
                    $this->error = $this->error . $key . "Invalid email!<br>";
                }
            }

            // Checks if input First name input matches
            if ($key == "first_name")
            {
                // Checks data/key value of First name if it has number in the beginning
                if (is_numeric($value)) {
                    $this->error = $this->error . $key . "First name cant have a number<br>";
                }
                // Checks data/key value of First name if it has space in the beginning
                if (strstr($value, " ")) {
                    $this->error = $this->error . $key . "First name cant have a space<br>";
                }
            }

            // Checks if input Last name input matches
            if ($key == "last_name")
            {
                 // Checks data/key value of Last name if it has number in the beginning
                if (is_numeric($value)) {
                    $this->error = $this->error . $key . "Last name cant be a number<br>";
                }
                // Checks data/key value of Last name if it has space in the beginning
                if (strstr($value, " ")) {
                    $this->error = $this->error . $key . "Last name cant have a space<br>";
                }
            }
        }
        // If no Error found creates user Table
        if($this->error == "")
        {
            // No Error
            $this->create_user($data);
        }else
        {
            // Found error returns from the beginning
            return $this->error;
        }
    }

    // Creates table
    public function create_user($data)
    {
        // Sets data/key values
        $first_name = ucfirst($data['first_name']);
        $last_name = ucfirst($data['last_name']);
        $email = $data['email'];
        $password = $data['password'];

        // To create custom url_address
        $url_address = strtolower($first_name) . "." . strtolower($last_name);
        
        // To create custom userid
        $userid = $this->create_userid();

        $profile_default = "upload/profile.jpg";

        // Inserts values to table
        $query = "INSERT INTO users 
        (userid, first_name, last_name, email, password, url_address, profile_image) 
        VALUES 
        ('$userid', '$first_name', '$last_name', '$email', '$password', '$url_address', '$profile_default')";

        // Creates new Database
        $DB = new Database();
        // Saves to Database Table
        $DB->save($query);
    }

    // Creates userid
    private function create_userid()
    {
        // Sets userid length from 4-19
        $length = rand(4, 19);
        $number = "";
        // Randomize numbers
        for ($i=0; $i < $length; $i++)
        {
            $new_rand = rand(0,9);
            $number = $number . $new_rand;
        }
        return $number;
    }
}
?>
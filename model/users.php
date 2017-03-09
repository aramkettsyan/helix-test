<?php

class Users{

    public function insertUsers($data){
        global $link;
        $content = file_get_contents($data['file']['tmp_name']);
        $users = json_decode($content);
        $sql = 'INSERT INTO users (firstname, lastname, age, city, email, country, bankAccountNumber, creditCardNumber, phones, addresses, created, modified) VALUES ';
        $i = 0;
        $len = count($users);
        foreach ($users as $u) {
            $sql .= "('" . mysqli_real_escape_string($link, $u->firstName) . "', '" . mysqli_real_escape_string($link, $u->lastName) . "', '" . mysqli_real_escape_string($link, $u->age) . "','" . mysqli_real_escape_string($link, $u->city) . "','" . mysqli_real_escape_string($link, $u->email) . "','" . mysqli_real_escape_string($link, $u->country) . "','" . mysqli_real_escape_string($link, $u->bankAccountNumber) . "','" . mysqli_real_escape_string($link, $u->creditCardNumber) . "','" . mysqli_real_escape_string($link, serialize($u->phones)) . "','" . mysqli_real_escape_string($link, serialize($u->addresses)) . "','" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "')";
            if ($i != $len - 1) {
                $sql .= ",";
            } else {
                $sql .= ";";
            }
            $i++;
        }

        return $sql;
    }


    public function selectUsers(){
        global $link;
        $res = $link->query('SELECT * FROM  `users`');
        $users = array();
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $users[] = $row;
            }
        }

        return $users;
    }

    public function selectUserById($id){
        global $link;
        $res = $link->query('SELECT * FROM  `users` WHERE id='.$id.' LIMIT 1');
        $users = array();
        if ($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $users[] = $row;
            }
        }

        return $users;
    }


    public function updateUserById($userData){
        global $link;
        $res = $link->query('UPDATE `users` SET 
          firstname="'.mysqli_real_escape_string($link, $userData["firstname"]).'", 
          lastname="'.mysqli_real_escape_string($link, $userData["lastname"]).'", 
          age="'.mysqli_real_escape_string($link, $userData["age"]).'", 
          city="'.mysqli_real_escape_string($link, $userData["city"]).'", 
          email="'.mysqli_real_escape_string($link, $userData["email"]).'", 
          country="'.mysqli_real_escape_string($link, $userData["country"]).'", 
          bankAccountNumber="'.mysqli_real_escape_string($link, $userData["bankAccountNumber"]).'", 
          creditCardNumber="'.mysqli_real_escape_string($link, $userData["creditCardNumber"]).'", 
          phones="'.mysqli_real_escape_string($link, serialize($userData["phone"])).'", 
          addresses="'.mysqli_real_escape_string($link, serialize($userData["addresses"])).'" 
         WHERE id='.$userData['id'].' LIMIT 1');
        if ($res == true) {
            return true;
        }

        return false;
    }


    public function insert($data){
        global $link;
        $sql = 'INSERT INTO users (firstname, lastname, age, city, email, country, bankAccountNumber, creditCardNumber, phones, addresses, created, modified) VALUES ';
        $sql .= "('" . mysqli_real_escape_string($link, $data['firstname']) . "', '" . mysqli_real_escape_string($link, $data['firstname']) . "', '" . mysqli_real_escape_string($link, $data['age']) . "','" . mysqli_real_escape_string($link, $data['city']) . "','" . mysqli_real_escape_string($link, $data['email']) . "','" . mysqli_real_escape_string($link, $data['country']) . "','" . mysqli_real_escape_string($link, $data['bankAccountNumber']) . "','" . mysqli_real_escape_string($link, $data['creditCardNumber']) . "','" . mysqli_real_escape_string($link, serialize($data['phones'])) . "','" . mysqli_real_escape_string($link, serialize($data['addresses'])) . "','" . date("Y-m-d H:i:s") . "','" . date("Y-m-d H:i:s") . "')";

        $res = $link->query($sql);
        if($res){
            return true;
        }
        return false;
    }




    public function deleteUsers($user_ids){
        global $link;
        $sql = '';
        foreach ($user_ids as $id){
            if(!$sql){
                $sql.=$id;
            }else{
                $sql.=','.$id;
            }
        }
        $res = $link->query('DELETE FROM `users` WHERE  id IN ('.$sql.')');
        return $res;
    }


}
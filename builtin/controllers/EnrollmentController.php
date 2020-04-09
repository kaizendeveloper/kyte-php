<?php

class EnrollmentController extends ModelController
{
    /* override authenticate to make public controller */
    protected function authenticate() {}

    // new - create new user with sign up token
    public function new($data)
    {
        $response = [];

        try {
            $obj = new \Kyte\ModelObject(Account);
            if ($obj->retrieve('email', $data['email'])) {
                throw new \Exception("Account already exists");
            }
            $time = time();
			$exp_time = $time+(60*60);
            $data['password'] = 't0k3n'.hash_hmac('sha256', $data['email'].'-'.$time, $exp_time);
            if ($obj->create($data)) {
                $response = $obj->getAllParams($this->dateformat);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $response;
    }

    // update - finish user registration and udpate
    public function update($field, $value, $data)
    {
        if (!$field || !$value) throw new \Exception("Field and Value params not set");

        $response = [];

        try {
            $obj = new \Kyte\ModelObject(Account);
            $obj->retrieve('id', $value);
            if ($obj) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $obj->save($data);
                $response = $obj->getAllParams($this->dateformat);
                $response['password'] = '';     // better leave password hash empty - no need for front-end to get it
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $response;
    }

    // get
    public function get($field, $value)
    {
        if (!$field || !$value) throw new \Exception("Field and Value params not set");

        $response = [];

        try {
            $objs = new \Kyte\Model(Account);
            $objs->retrieve($field, $value);
            foreach ($objs->objects as $obj) {
                // return list of data
                $item = $obj->getAllParams($this->dateformat);
                $item['password'] = '';     // better leave password hash empty - no need for front-end to get it
                $response[] = $item;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $response;
    }

    // delete
    public function delete($field, $value)
    {
        throw new \Exception("Undefined request method");
    }
}

?>

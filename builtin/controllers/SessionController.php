<?php

class SessionController extends ModelController
{
    protected $session;

    protected function authenticate()
    {
        $this->session = new \Kyte\SessionManager(Session, Account);
    }
    
    // new - creates new session
    public function new($data)
    {
        $response = [];

        try {
            foreach (['email', 'password'] as $param) {
				if (!isset($data[$param]))
					throw new Exception("Incomplete data passed");
			}
			$response = [ 'token' => $this->session->create($data['email'], $data['password']) ];
        } catch (Exception $e) {
            throw $e;
        }

        return $response;
    }

    // update
    public function update($field, $value, $data)
    {
        throw new \Exception("Undefined request method");
    }

    // get - validate session
    public function get($field, $value)
    {
        try {
            // ***************************************************
            // code to get user id should move to Kyte lib instead
            $s = new \Kyte\ModelObject(Session);
            if (!$s->retrieve('token', $this->token)) {
                throw new Exception("Must be logged in.");
            }
            $response = [ 'token' => $this->session->validate($this->token), 'uid' => $s->getParam('uid') ];
            // ***************************************************
        } catch (Exception $e) {
            throw $e;
        }

        return $response;
    }

    // delete - destroy session
    public function delete($field, $value)
    {
        try {
            $this->session->validate($this->token);
            $this->session->destroy();
        } catch (Exception $e) {
            throw $e;
        }

        return [ 'token' => '' ];
    }
}

?>
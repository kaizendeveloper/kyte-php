<?php

namespace Kyte\Mvc\Controller;

class SessionController extends ModelController
{
    public function hook_init()
    {
        // make a public controller
        $this->requireAuth = false;
        $this->getFKTables = SESSION_RETURN_FK;
    }

    // new - creates new session
    public function new($data)
    {
        $response = [];

        try {
            // check for required params
            foreach ([USERNAME_FIELD, PASSWORD_FIELD] as $param) {
				if (!isset($data[$param]))
					throw new \Exception("Incomplete data passed");
			}

            // create session for user and obtain user information
            $response = $this->session->create($data[USERNAME_FIELD], $data[PASSWORD_FIELD]);
            $obj = new \Kyte\Core\ModelObject(User);
            if (!$obj->retrieve('id', $response['uid'])) {
                throw new \Exception("Unable to find user information");    
            }
            $response['User'] = $this->getObject($obj);

            // get user account
            $account = new \Kyte\Core\ModelObject(Account);
            if (!$account->retrieve('id', $obj->kyte_account)) {
                throw new \Exception("Unable to find account associated with user");
            }

            // get api associated with account
            $account_api = new \Kyte\Core\ModelObject(APIKey);
            if (!$account_api->retrieve('kyte_account', $account->id)) {
                throw new \Exception("[ERROR] Unable to find API information for account");
            }

            // return account information in response - this is required for API handoff between master account and subaccounts
            $this->response['kyte_pub'] = $account_api->public_key;
            $this->response['kyte_num'] = $account->number;
            $this->response['kyte_iden'] = $account_api->identifier;

            $this->response['token'] = $response['txToken'];
            $this->response['session'] = $response['sessionToken'];
            $this->response['data'] = $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // update
    public function update($field, $value, $data)
    {
        throw new \Exception("Undefined request method");
    }

    // get - validate session
    public function get($field, $value)
    {
        throw new \Exception("Undefined request method");
    }

    // delete - destroy session
    public function delete($field, $value)
    {
        try {
            $this->session->destroy();
        } catch (\Exception $e) {
            throw $e;
        }

        $this->response['token'] = 0;
        $this->response['session'] = 0;
        $this->response['data'] = [ 'txToken' => 0, 'sessionToken' => 0 ];
    }
}

?>

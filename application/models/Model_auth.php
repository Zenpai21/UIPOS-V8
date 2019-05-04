 <?php

class Model_auth extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	// check if username exist on user table
	public function check_user($username)
	{
		if($username) {
			$sql = 'SELECT * FROM users WHERE username = ?';
			$query = $this->db->query($sql, array($username));
			$result = $query->num_rows();
			return ($result == 1) ? true : false;
		}
		return false;
	}

	// login exist check
	public function login($username, $password) {
		if($username && $password) {
			$sql = "SELECT * FROM users WHERE username = ?";
			$query = $this->db->query($sql, array($username));

			if($query->num_rows() == 1) {
				$result = $query->row_array();

				$hash_password = password_verify($password, $result['password']);
				if($hash_password === true) {
					return $result;
				}
				else {
					return false;
				}


			}
			else {
				return false;
			}
		}
	}
  

}

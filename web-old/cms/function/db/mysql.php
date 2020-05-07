<?php
namespace DB;
final class MySQL {
	private $link;

	public function __construct($hostname, $username, $password, $database, $port = '3306') {
		if (!$this->link = mysqli_connect($hostname . ':' . $port, $username, $password)) {
			trigger_error('Error: Could not make a database link using ' . $username . '@' . $hostname);
			exit();
		}

		if (!mysqli_select_db($database, $this->link)) {
			trigger_error('Error: Could not connect to database ' . $database);
			exit();
		}

		mysqli_query($koneksi, "SET NAMES 'utf8'", $this->link);
		mysqli_query($koneksi, "SET CHARACTER SET utf8", $this->link);
		mysqli_query($koneksi, "SET CHARACTER_SET_CONNECTION=utf8", $this->link);
		mysqli_query($koneksi, "SET SQL_MODE = ''", $this->link);
	}

	public function query($sql) {
		if ($this->link) {
			$resource = mysqli_query($koneksi, $sql, $this->link);

			if ($resource) {
				if (is_resource($resource)) {
					$i = 0;

					$data = array();

					while ($result = mysqli_fetch_assoc($resource)) {
						$data[$i] = $result;

						$i++;
					}

					mysqli_free_result($resource);

					$query = new \stdClass();
					$query->row = isset($data[0]) ? $data[0] : array();
					$query->rows = $data;
					$query->num_rows = $i;

					unset($data);

					return $query;
				} else {
					return true;
				}
			} else {
				$trace = debug_backtrace();

				trigger_error('Error: ' . mysql_error($this->link) . '<br />Error No: ' . mysql_errno($this->link) . '<br /> Error in: <b>' . $trace[1]['file'] . '</b> line <b>' . $trace[1]['line'] . '</b><br />' . $sql);
			}
		}
	}

	public function escape($value) {
		if ($this->link) {
			return mysqli_real_escape_string($value, $this->link);
		}
	}

	public function countAffected() {
		if ($this->link) {
			return mysqli_affected_rows($this->link);
		}
	}

	public function getLastId() {
		if ($this->link) {
			return mysqli_insert_id($this->link);
		}
	}

	public function __destruct() {
		if ($this->link) {
			mysqli_close($this->link);
		}
	}
}
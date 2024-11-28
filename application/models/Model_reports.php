<?php

class Model_reports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*getting the total months*/
	private function months()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}

	/* getting the year of the orders */
	public function getOrderYear()
	{
		$sql = "SELECT * FROM orders order by id desc";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();

		$return_data = array();
		foreach ($result as $k => $v) {
			//$date = $v['date_time'];
			//$date=substr($v['date_time'],0,4);
			$date = date('Y', strtotime($v['date_time']));
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the year and moths 4/5/19 chenged to remain from paid-status
	public function getOrderData($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM orders order by id desc";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					//$month_year =  $v['date_time'];
					$month_year = date('Y-m', strtotime($v['date_time']));

					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}


			return $final_data;

		}
	}

	public function getdatewise($date)
	{
		if ($date) {

			$date = date('Y-m-d', strtotime($date));
			$sql = "SELECT sum(pay) as total FROM orders WHERE date_time = '$date' order by id desc";
			$query = $this->db->query($sql);
			$res = $query->result_array();
			return $res;

		} else {

			$date = date('Y-m-d');
			$sql = "SELECT sum(pay) as total FROM orders WHERE date_time = '$date' order by id desc";
			$query = $this->db->query($sql);
			$res = $query->result_array();
			return $res;
		}



	}

	//10/4/19 By RAMIZ for paid and unpaid details
	public function paid_data_order($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM orders where pay>0 order by id desc";// and branch_id=2";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					//$month_year =  $v['date_time'];
					$month_year = date('Y-m', strtotime($v['date_time']));

					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}


			return $final_data;


		}
	}

	public function remain_data_order($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM orders where remain>0 order by id desc";// and branch_id=2 ";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					//$month_year =  $v['date_time'];
					$month_year = date('Y-m', strtotime($v['date_time']));

					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}


			return $final_data;


		}
	}


	//Wagholi Report section

	public function getOrderYearWagholi()
	{
		$sql = "SELECT * FROM orders where branch_id=2 order by id desc";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();

		$return_data = array();
		foreach ($result as $k => $v) {
			//$date = $v['date_time'];
			//$date=substr($v['date_time'],0,4);
			$date = date('Y', strtotime($v['date_time']));
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the year and moths 4/5/19 chenged to remain from paid-status
	public function getOrderDataWagholi($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM orders where branch_id=2 order by id desc";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					//$month_year =  $v['date_time'];
					$month_year = date('Y-m', strtotime($v['date_time']));

					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}


			return $final_data;

		}
	}

	public function getdatewiseWagholi($date)
	{
		if ($date) {

			$date = date('Y-m-d', strtotime($date));
			$sql = "SELECT sum(pay) as total FROM orders WHERE date_time = '$date' and branch_id=2 order by id desc";
			$query = $this->db->query($sql);
			$res = $query->result_array();
			return $res;

		} else {

			$date = date('Y-m-d');
			$sql = "SELECT sum(pay) as total FROM orders WHERE date_time = '$date' and branch_id=2 order by id desc";
			$query = $this->db->query($sql);
			$res = $query->result_array();
			return $res;
		}



	}

	//10/4/19 By RAMIZ for paid and unpaid details
	public function paid_data_orderWagholi($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM orders where pay>0 and branch_id=2 order by id desc";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					//$month_year =  $v['date_time'];
					$month_year = date('Y-m', strtotime($v['date_time']));

					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}


			return $final_data;


		}
	}

	public function remain_data_orderWagholi($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM orders where remain>0 and branch_id=2 order by id desc";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					//$month_year =  $v['date_time'];
					$month_year = date('Y-m', strtotime($v['date_time']));

					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}


			return $final_data;


		}
	}

	//Shivaji Nagar Report section 19/4/2019
	public function getOrderYearShivajinagar()
	{
		$sql = "SELECT * FROM orders where branch_id=1 order by id desc";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();

		$return_data = array();
		foreach ($result as $k => $v) {
			//$date = $v['date_time'];
			//$date=substr($v['date_time'],0,4);
			$date = date('Y', strtotime($v['date_time']));
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the year and moths 4/5/19 chenged to remain from paid-status
	public function getOrderDataShivajinagar($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM orders where branch_id=1 order by id desc";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					//$month_year =  $v['date_time'];
					$month_year = date('Y-m', strtotime($v['date_time']));

					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}


			return $final_data;

		}
	}

	public function getdatewiseShivajinagar($date)
	{
		if ($date) {

			$date = date('Y-m-d', strtotime($date));
			$sql = "SELECT sum(pay) as total FROM orders WHERE date_time = '$date' and branch_id=1 order by id desc";
			$query = $this->db->query($sql);
			$res = $query->result_array();
			return $res;

		} else {

			$date = date('Y-m-d');
			$sql = "SELECT sum(pay) as total FROM orders WHERE date_time = '$date' and branch_id=1 order by id desc";
			$query = $this->db->query($sql);
			$res = $query->result_array();
			return $res;
		}



	}

	//10/4/19 By RAMIZ for paid and unpaid details
	public function paid_data_orderShivajinagar($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM orders where pay>0 and branch_id=1 order by id desc";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					//$month_year =  $v['date_time'];
					$month_year = date('Y-m', strtotime($v['date_time']));

					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}


			return $final_data;


		}
	}

	public function remain_data_orderShivajinagar($year)
	{
		if ($year) {
			$months = $this->months();

			$sql = "SELECT * FROM orders where remain>0 and branch_id=1 order by id desc";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year . '-' . $month_y;

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					//$month_year =  $v['date_time'];
					$month_year = date('Y-m', strtotime($v['date_time']));

					if ($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}


			return $final_data;


		}
	}




}
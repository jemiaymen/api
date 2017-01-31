<?php

class My {

    private $c;
    private $qry;
    private $re;

    public function __construct(){
		$this->c = new mysqli(HOST, USER, PW, DB);
	}

    public function debug_query(){
        echo "<p>". $this->qry . "</p>";
    }

    public function debug_val($val){
        echo "<pre>";
        var_dump($val);
        echo "</pre>";
    }

    public function Update($table,$data,$cond){

        $cond = addslashes($cond);

		$condition = " WHERE  $cond";

		$qry = "UPDATE $table SET " ;

		$count = count($data);

		foreach ($data as $key => $value) {

			$value = addslashes($value);

			if ( $key == "id"){
				$condition .= $value ;
			}else if($count == 1) {

				$qry .= " $key = '$value' ";

			}else {
				$qry .= " $key = '$value' ,";
			}
			
			$count -= 1;

		}

		$this->qry = $qry . $condition;
	}

	public function Insert($table,$data){

		$acl = $this->acl;

		$qr = "INSERT INTO $table (  " ;
		
		$valu = " VALUES ( " ;

		$count = count($data);

		foreach ($data as $key => $value) {

			$value = addslashes($value);

			if($count == 1) {

				$valu .= " '$value' ) ";
				$qr .= " $key )";

			}else {
				$valu .= " '$value' , ";
				$qr .= " $key , ";
			}
			
			$count -= 1;

		}

		$this->qry = $qr . $valu;
	}

    public function Select($table,$data,$condition="1=1",$limit = 30){
        
        $q = "SELECT ";
        $f = " FROM $table";
        $condition = addslashes($condition);

        $cond = " WHERE $condition";

        $l = " LIMIT $limit";

        $count = count($data);

		foreach ($data as $value) {

			$value = addslashes($value);

			if($count == 1) {

				$q .= " $value ";

			}else {
				$q .= " $value , ";
			}
			
			$count -= 1;
		}

        $this->qry = $q . $f . $cond . $l;
    }

    public function Delete($table,$condition){
        
        $q = "DELETE FROM $table";
        $condition = addslashes($condition);

        $cond = " WHERE $condition";



        $this->qry = $q . $cond ;
    }

    public function Run(){
       $this->re =  $this->c->query($this->qry);
    }

    public function Fetch(){
        if ($this->re) {
			$i = 0;
			$res = array();
			while ($r = $this->re->fetch_assoc() ) {
				$res[$i] = $r;
				$i += 1;
			}
			$this->re->free();
            return $res;
		}
    }

    public function Sql($sql){
        $sql = addslashes($sql);
        $this->qry = $sql;
    }

}

class db extends My {

    private $opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public function __construct(){
		$this->c = new PDO(MYDNS, USER, PW, $this->opt);
	}

    public function Fetch(){
        return $this->re->fetchAll();
    }

}


<?php

namespace weTask\Product;
class Product{
    public $id = "";
    public $name = "";
    public $con = "";

    public function __construct(){
    	session_start();
        $this->con = mysqli_connect("localhost", "root", "password","crud");

    }

    public function prepare($data = ''){
        if(array_key_exists('name',$data)){
            $this->name = $data['name'];
            if(isset($data['id'])) {
                $this->id = $data['id'];
            }
        }
        return $this;
    }

    public function store(){
		$st = $this->con->prepare("insert into todos (name) values(?)");
		if($this->name) {
            $st->bind_param("s", $this->name);
            if ($st->execute()) {
                // $_SESSION['msg'] = '<h3><font color="green">'."Successfully Added...".'</font></h3>';
                header("location: index.php");
            } else {
                return false;
                //$_SESSION['msg'] = '<h3><font color="red">'."Error While Added...".'</font></h3>';
                header("location: index.php");
            }
        }else{
            header("location: index.php");
        }

         return $this;
    }

    public function index(){

    	$st=$this->con->prepare("SELECT * FROM todos WHERE status = 0");
		$st->execute();
		$rs=$st->get_result();
		 while ($row=$rs->fetch_assoc()) {
		 	$this->data[]= $row;
		 }

		 return $this->data;
    }

    public function active(){
        if(!empty($_POST['myStatus'])){
           foreach ($_POST['myStatus'] as $id){
               $st1 = $this->con->prepare("UPDATE todos SET status=1 WHERE id=$id");
               $st1->execute();
           }
        }
        header("location: index.php");
        return $this;
    }
    public function complete(){
        $this->data = [];
        $st=$this->con->prepare("SELECT * FROM todos");
        $st->execute();
        $rs=$st->get_result();
        while ($row=$rs->fetch_assoc()) {
            $this->data[]= $row;
        }
        return $this->data;
    }

    public function update(){
    	$st1 = $this->con->prepare("UPDATE todos SET name=?  WHERE id=?");
		 $st1->bind_param("si", $this->name,$this->id);
		if($st1->execute()){
                //$_SESSION['msg'] = '<h3><font color="green">'."Successfully Updated...".'</font></h3>';
                header("location: index.php");
            }else{
                //$_SESSION['msg'] = '<h3><font color="red">'."Error While Update...".'</font></h3>';
                header("location: index.php");
            }

    }

    public function delete()
    {
        if (!empty($_POST['myClearStatus'])) {
            foreach ($_POST['myClearStatus'] as $id) {
                $st2 = $this->con->prepare("DELETE FROM  todos  WHERE Id=$id");
                $st2->execute();
            }
        }
        header("location: complete.php");
        return $this;
    }
}
?>
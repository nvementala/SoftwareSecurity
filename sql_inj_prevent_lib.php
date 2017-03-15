<?php
// This is the SQL Injection Prevention Library  developed by
//   NIKHIL MEKA       - nmeka@asu.edu
//   NIKHIL VEMENTALA  - nvementa@asu.edu
//
// @Waring:
// In order to provide better security we slightly manupulate the data which is stored on to database.
// We highly recommend you to use only this api provided to retrive data from the database.
// We do not recommend to use this library to store passwords, as it changes the hash of the original string.
//

function tag_str($name){
  $list = str_split($name);
  $s="";
  foreach($list as $symbol){
    if(!ctype_alnum($symbol) && $symbol!=" "){
      $symbol ="&|\\".$symbol;
    }
    $s = $s.$symbol;
  }
  return $s;
}

function untag($str){
  return str_replace('&|','',$str);
}

function retag($query){
  return str_replace('&|','&|\\',$query);
}

class mysql_iresult
{
    /*
    var $field_count;
    var $current_field;
    var $lengths;
    var $num_rows;*/
    public function __construct($result) {
        if(isset($result))
          $this->result = $result;
        if(isset($result->field_count))
          $this->field_count = $result->field_count;
        if(isset($result->current_field))
          $this->current_field = $result->current_field;
        if(isset($result->lengths))
          $this->lengths = $result->lengths;
        if(isset($result->num_rows))
          $this->num_rows = $result->num_rows;
    }

    public function adapt($value)
    {
      $this->result = $value;
    }

    public function fetch_field_direct($field_num){
      return $this->result->fetch_field_direct($field_num);
    }

    public function fetch_field(){
      return $this->result->fetch_field();
    }

    public function fetch_fields(){
      return $this->result->fetch_fields();
    }

    public function free($value)
    {
      $this->result->free();
    }

    public function fetch_object(){
      if (!isset($this->result)) {
        echo "The object invoking this method, it is not set";
        die;
      }
      $obj = $this->result->fetch_object();
      $a = clone($obj);
      foreach($obj as $column_name => $value){
        $value = retag($value);
        $a->{$column_name}=$value;
      }
      return $a;
    }

    public function fetch_object_toDisplay(){
      if (!isset($this->result)) {
        echo "The object invoking this method is not set";
        die;
      }
      $obj = $this->result->fetch_object();
      $a = clone($obj);
      foreach($obj as $column_name => $value){
        $value = untag($value);
        $a->{$column_name}=$value;
      }
      return $a;
    }

    public function fetch_row(){
        if (!isset($this->result)) {
          echo "The object invoking this method is not set";
          die;
        }
        $row = $this->result->fetch_row();
        foreach($row as $column_name => $value){
          $value = retag($value);
          $a[$column_name]=$value;
        }
        return $a;
    }

    public function fetch_row_toDisplay(){
        if (!isset($this->result)) {
          echo "The object invoking this method is not set";
          die;
        }
        $row = $this->result->fetch_row();
        foreach($row as $column_name => $value){
          $value = untag($value);
          $a[$column_name]=$value;
        }
        return $a;
    }

    public function fetch_assoc(){
      if (!isset($this->result)) {
        echo "The object invoking this method is not set";
        die;
      }
      $row = $this->result->fetch_assoc();
      foreach($row as $column_name => $value){
        $value = retag($value);
        $a[$column_name]=$value;
      }
      return $a;
    }

    public function fetch_assoc_toDisplay()
    {
      if (!isset($this->result)) {
        echo "The object invoking this method is not set";
        die;
      }
      $row = $this->result->fetch_assoc();
      foreach($row as $column_name => $value){
        $value = untag($value);
        $a[$column_name]=$value;
      }
      return $a;
    }

    public function fetch_array($resulttype){
      if (!isset($this->result)) {
        echo "The object invoking this method is not set";
        die;
      }
        $row = $this->result->fetch_array($resulttype);
        foreach($row as $column_name => $value){
          $value = retag($value);
          $a[$column_name]=$value;
        }
        return $a;
    }

    public function fetch_array_toDisplay($resulttype){
      if (!isset($this->result)) {
        echo "The object invoking this method is not set";
        die;
      }
        $row = $this->result->fetch_array($resulttype);
        foreach($row as $column_name => $value){
          $value = untag($value);
          $a[$column_name]=$value;
        }
        return $a;
    }

    public function fetch_all($resulttype){
      if (!isset($this->result)) {
        echo "The object invoking this method is not set";
        die;
      }
      $res =  $this->result->fetch_all($resulttype);
      $arr = array();
      foreach($res as $index => $row){
        foreach($row as $column_name => $value){
          $value = retag($value);
          $a[$column_name]=$value;
        }
        array_push($arr,$a);
      }
      return $arr;
    }

    public function fetch_all_toDisplay($resulttype){
      if (!isset($this->result)) {
        echo "The object invoking this method is not set";
        die;
      }
      $res =  $this->result->fetch_all($resulttype);
      $arr = array();
      foreach($res as $index => $row){
        foreach($row as $column_name => $value){
          $value = untag($value);
          $a[$column_name]=$value;
        }
        array_push($arr,$a);
      }
      return $arr;
    }
}


// Procedural Oriented functions
function mysql_iquery($conn,$query){
  $main_res = mysqli_query($conn,$query);
  $returnvalue = new mysql_iresult($main_res);
  if(is_bool($main_res))
    return $main_res;
  else {
    return $returnvalue;
  }
}
function mysql_ifetch_all($result,$resulttype){
  if (!isset($result)) {
    echo "The object is not set";
    die;
  }
  $res =  $result->result->fetch_all($resulttype);
  $arr = array();
  foreach($res as $index => $row){
    foreach($row as $column_name => $value){
      $value = retag($value);
      $a[$column_name]=$value;
    }
    array_push($arr,$a);
  }
  return $arr;
}

function mysql_ifetch_all_toDisplay($result,$resulttype){
  if (!isset($result)) {
    echo "The object is not set";
    die;
  }
  $res =  $result->result->fetch_all($resulttype);
  $arr = array();
  foreach($res as $index => $row){
    foreach($row as $column_name => $value){
      $value = untag($value);
      $a[$column_name]=$value;
    }
    array_push($arr,$a);
  }
  return $arr;
}

function mysql_ifetch_array($result,$resulttype){
  if (!isset($result)) {
    echo "The object is not set";
    die;
  }
    $row = $result->result->fetch_array($resulttype);
    foreach($row as $column_name => $value){
      $value = retag($value);
      $a[$column_name]=$value;
    }
    return $a;
}

function mysql_ifetch_array_toDisplay($result,$resulttype){
  if (!isset($result)) {
    echo "The object is not set";
    die;
  }
    $row = $result->result->fetch_array($resulttype);
    foreach($row as $column_name => $value){
      $value = untag($value);
      $a[$column_name]=$value;
    }
    return $a;
}

function mysql_ifetch_assoc($result){
  if (!isset($result)) {
    echo "The object is not set";
    die;
  }
  $row = $result->result->fetch_assoc();
  foreach($row as $column_name => $value){
    $value = retag($value);
    $a[$column_name]=$value;
  }
  return $a;
}

function mysql_ifetch_assoc_toDisplay($result){
  if (!isset($result)) {
    echo "The object is not set";
    die;
  }
  $row = $result->result->fetch_assoc();
  foreach($row as $column_name => $value){
    $value = untag($value);
    $a[$column_name]=$value;
  }
  return $a;
}

function mysql_ifetch_field_direct($result,$field_num){
  return $result->result->fetch_field_direct($field_num);
}

function mysql_ifetch_field($result){
  return $result->result->fetch_field();
}

function mysql_ifetch_fields($result){
  return $result->result->fetch_fields();
}

function mysql_ifetch_lengths($res){
  return mysqli_fetch_lengths($res->result);
}

function mysql_ifetch_object($result){
  if (!isset($result->result)) {
    echo "The object is not set";
    die;
  }
  $obj = $result->result->fetch_object();
  $a = clone($obj);
  foreach($obj as $column_name => $value){
    $value = retag($value);
    $a->{$column_name}=$value;
  }
  return $a;
}

function mysql_ifetch_object_toDisplay($result){
  if (!isset($result->result)) {
    echo "The object is not set";
    die;
  }
  $obj = $result->result->fetch_object();
  $a = clone($obj);
  foreach($obj as $column_name => $value){
    $value = untag($value);
    $a->{$column_name}=$value;
  }
  return $a;
}

function mysql_ifetch_row($result){
    if (!isset($result->result)) {
      echo "The object invoking this method, it is not set";
      die;
    }
    $row = $result->result->fetch_row();
    foreach($row as $column_name => $value){
      $value = untag($value);
      $a[$column_name]=$value;
    }
    return $a;
}

function mysql_ifetch_row_toDisplay($result){
    if (!isset($result->result)) {
      echo "The object invoking this method, it is not set";
      die;
    }
    $row = $result->result->fetch_row();
    foreach($row as $column_name => $value){
      $value = untag($value);
      $a[$column_name]=$value;
    }
    return $a;
}

function mysql_ifield_count($res){
  return mysqli_field_count($res->result);
}

function mysql_ifree_result($res){
  mysqli_free_result($res->result);
  unset($res);
}


function mysql_inum_rows($res){
  return mysqli_num_rows($res->result);
}


function mysql_ifield_tell($res){
  return mysqli_field_tell($res->result);
}
?>

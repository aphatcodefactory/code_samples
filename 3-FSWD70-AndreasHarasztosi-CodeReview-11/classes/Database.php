<?php

  class Database {
    public $mysqli;

    function __construct($hostname, $dbuser, $dbpw, $dbname)  {
      $this->mysqli = mysqli_connect($hostname, $dbuser, $dbpw, $dbname);
      if ($this->mysqli->connect_errno) {
         die('Failed to connect to MySQL: ' . $mysqli->connect_error . ' (errNo: '.$this->mysqli->connect_errno.')');
      }
    } // end: __construct

    public function insertTbl($tblName, $cols = array(), $values) {
      $colsStr = implode($cols, ', ');
      $valuesStr = implode($values, "', '");
      $sql = "INSERT INTO $tblName($colsStr) VALUES('".$valuesStr."')";

      $res = mysqli_query($this->mysqli, $sql);

      if ($res) {
        return 'Insert was successful.';
      } else {
        return'Something went wrong, try again later...';
      }
    } // end: insertTbl

    public function selectRow($tblName, $cols, $whereClause = '') {
      $sql = "SELECT $cols FROM $tblName $whereClause;";
      return mysqli_query($this->mysqli, $sql);
    } // end: selectRow

    public function updateRow($tblName, $cols, $whereClause = '') {
      $sql = "UPDATE $tblName SET $cols $whereClause;";
      $res = mysqli_query($this->mysqli, $sql);
      if ($res) {
        return 'Update was successful.';
      } else {
        return 'Something went wrong: ' . $this->mysqli->error . ' (errNo: '.$this->mysqli->errno.')';
      }
    } // end: updateRow

    public function deleteRow($tblName, $whereClause) {
      $sql = "DELETE FROM $tblName $whereClause;";
      $res = mysqli_query($this->mysqli, $sql);
      if ($res) {
        return 'Delete was successful.';
      } else {
        return 'Something went wrong: ' . $this->mysqli->error . ' (errNo: '.$this->mysqli->errno.')';
      }
    } // end: deleteRow
  } // end: class Database

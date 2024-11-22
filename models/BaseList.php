<?php
abstract class BaseList {
    protected $id;
    protected $dataArray;

    public function __construct() {
        $this->id = 0;
        $this->dataArray = array();
    }

    public abstract function add($params);

    public function displayInfo() {
        foreach ($this->dataArray as $item) {
            $item->displayInfo();
        }
    }

    public function update($params){
    	foreach ($this->dataArray as $item){
        	if ($item->getId()==$params['id']){
            	$item->update($params);
                break;
            }
        }
    }

    public function delete($params) {
        for ($i = 0; $i < count($this->dataArray); $i++) {
            if ($params == $this->dataArray[$i]->getId()) {
                array_splice($this->dataArray, $i, 1);
                break;
            }
        }
    }

    public function exportAsJSON() {
        $result = array();
        foreach ($this->dataArray as $item) {
            array_push($result, $item->getAsAssocArray());
        }
        return $result;
    }

    public function exportAsTableData() {
        $result = '';
        foreach ($this->dataArray as $item) {
            $result .= $item->getAsTableRow();
        }
        return $result;
    }

    public function getItemById($id) {
        foreach ($this->dataArray as $item) {
            if ($item->getId() == $id) {
                return $item->getAsAssocArray();
            }
        }
    }
}
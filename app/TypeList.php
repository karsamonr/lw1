<?php
require_once('../app/BaseList.php');
require_once('../app/Type.php');

class TypeList extends BaseList {
    public function add($params) {
        $this->id++;
        $params['id'] = $this->id;
        $newType = new Type($params);
        array_push($this->dataArray, $newType);
    }

    public function exportAsArray() {
        $result = array(['name']);
        foreach ($this->dataArray as $item) {
            array_push($result, $item->getAsArray());
        }
        return $result;
    }

    public function exportAsXML() {
        $result = '<?xml version="1.0" encoding="UTF-8"?>';
        $result .= '<types>';
        for ($i = 0; $i < count($this->dataArray); $i++) {
            $typeData = $this->dataArray[$i]->getAsAssocArray();
            $result .= '<type>
                <id>'.$typeData['id'].'</id>
                <name>'.$typeData['name'].'</name>
            </type>';
        }
        $result .= '</types>';
        return $result;
    }
    
    public function readFromFile() {
        $row = 0;
        if (($handle = fopen("../data/types.csv", "r")) !== false) {
            while (($data = fgetcsv($handle,1000,",")) !== false) {
                if ($row) {
                    $this->add(array('name'=>$data[0]));
                } else 
                $row = true;
            }
            fclose($handle);
        }
    }

    public function saveToFile() {
        $fp = fopen('../data/types.csv', 'w');
        foreach ($this->exportAsArray() as $item) {
        fputcsv($fp, $item);
        }
        fclose($fp);
    }
}
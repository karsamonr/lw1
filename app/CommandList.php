<?php
require_once('../app/BaseList.php');
require_once('../app/Command.php');

class CommandList extends BaseList {
    public function add($params) {
        $this->id++;
        $params['id'] = $this->id;
        $newComm = new Command($params);
        array_push($this->dataArray, $newComm);
    }

    public function exportAsArray() {
        $result = array(['name', 'description', 'type', 'example']);
        foreach ($this->dataArray as $item) {
            array_push($result, $item->getAsArray());
        }
        return $result;
    }

    public function exportAsXML() {
        $result = '<?xml version="1.0" encoding="UTF-8"?>';
        $result .= '<commands>';
        for ($i = 0; $i < count($this->dataArray); $i++) {
            $comData = $this->dataArray[$i]->getAsAssocArray();
            $result .= '<command>
                <id>'.$comData['id'].'</id>
                <name>'.$comData['name'].'</name>
                <description>'.$comData['description'].'</description>
                <type>'.$comData['type'].'</type>
                <example>'.$comData['example'].'</example>
            </command>';
        }
        $result .= '</commands>';
        return $result;
    }

    public function readFromFile() {
        $row = 0;
        if (($handle = fopen("../data/commands.csv", "r")) !== false) {
            while (($data = fgetcsv($handle,1000,",")) !== false) {
                if ($row) {
                    $this->add(array('name'=>$data[0], 'description'=>$data[1], 'type'=>$data[2], 'example'=>$data[3]));
                } else
                $row = true;
            }
            fclose($handle);
        }
    }

    public function saveToFile() {
        $fp = fopen('../data/commands.csv', 'w');
        foreach ($this->exportAsArray() as $item) {
        fputcsv($fp, $item);
        }
        fclose($fp);
    }
}
<?php
require_once('../app/BaseList.php');
require_once('../app/Example.php');

class ExampleList extends BaseList {
    public function add($params) {
        $this->id++;
        $params['id'] = $this->id;
        $newExample = new Example($params);
        array_push($this->dataArray, $newExample);
    }

    public function exportAsArray() {
        $result = array(['exampleCode']);
        foreach ($this->dataArray as $item) {
            array_push($result, $item->getAsArray());
        }
        return $result;
    }

    public function exportAsXML() {
        $result = '<?xml version="1.0" encoding="UTF-8"?>';
        $result .= '<examples>';
        for ($i = 0; $i < count($this->dataArray); $i++) {
            $exampleData = $this->dataArray[$i]->getAsAssocArray();
            $result .= '<example>
                <id>'.$exampleData['id'].'</id>
                <exampleCode>'.$exampleData['exampleCode'].'</exampleCode>
            </example>';
        }
        $result .= '</examples>';
        return $result;
    }

    public function readFromFile() {
        $row = 0;
        if (($handle = fopen("../data/examples.csv", "r")) !== false) {
            while (($data = fgetcsv($handle,1000,",")) !== false) {
                if ($row) {
                    $this->add(array('exampleCode'=>$data[0]));
                } else 
                $row = true;
            }
            fclose($handle);
        }
    }

    public function saveToFile() {
        $fp = fopen('../data/examples.csv', 'w');
        foreach ($this->exportAsArray() as $item) {
        fputcsv($fp, $item);
        }
        fclose($fp);
    }
}
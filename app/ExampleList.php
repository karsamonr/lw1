<?php
require_once('../app/BaseList.php');
require_once('../app/Example.php');

class ExampleList extends BaseList {
    public function add($params) {
        if (isset($params['id'])) {
            $this->id++;
        } else {
            $this->id++;
            $params['id'] = $this->id;
        }
        $newExample = new Example($params);
        array_push($this->dataArray, $newExample);
    }

    public function exportAsArray() {
        $result = array(['example_code', 'command']);
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
                <example_code>'.$exampleData['example_code'].'</example_code>
                <command>'.$exampleData['command'].'</command>
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
                    $this->add(array('example_code'=>$data[0], 'command'=>$data[1]));
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

    public function getFromDatabase($conn) {
        $sql = "SELECT e.example_id id, e.example_code, c.com_name command FROM examples e INNER JOIN commands c ON e.command_id = c.command_id ORDER BY 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->add($row);
            }
        }
    }

    public function deleteFromDatabaseByID($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM examples WHERE example_id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return true;
    }

    public function addToDatabase($conn, $params) {
        $stmt = $conn->prepare("INSERT INTO examples VALUES (DEFAULT, ?, ?)");
        $code = $params['example_code'];
        $com = $params['command'];
        $stmt->bind_param("ss", $com, $code);
        $stmt->execute();
        return true;
    }

    public function updateDatabaseRow($conn, $params) {
        $stmt = $conn->prepare("UPDATE examples SET example_code = ?, command_id = ? WHERE example_id = ?");
        $code = $params['example_code'];
        $com = $params['command'];
        $id = $params['id'];
        $stmt->bind_param("sss", $code, $com, $id);
        $stmt->execute();
        return true;
    }
}
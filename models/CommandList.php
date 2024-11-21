<?php
require_once('../models/BaseList.php');
require_once('../models/Command.php');

class CommandList extends BaseList {
    public function add($params) {
        if (isset($params['id'])) {
            $this->id++;
        } else {
            $this->id++;
            $params['id'] = $this->id;
        }
        $newComm = new Command($params);
        array_push($this->dataArray, $newComm);
    }

    public function exportAsArray() {
        $result = array(['name', 'description', 'type']);
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
            </command>';
        }
        $result .= '</commands>';
        return $result;
    }
    
    public function exportAsDropdownItems() {
        $result = '';
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            $result .= '<option value="'.$itemData['id'].'">'.$itemData['name'].'</option>';
        }
        return $result;
    }

    public function readFromFile() {
        $row = 0;
        if (($handle = fopen("../data/commands.csv", "r")) !== false) {
            while (($data = fgetcsv($handle,1000,",")) !== false) {
                if ($row) {
                    $this->add(array('name'=>$data[0], 'description'=>$data[1], 'type'=>$data[2]));
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

    public function getFromDatabase($conn) {
        $sql = "SELECT c.command_id id, c.com_name name, c.description, t.type_name type FROM commands c INNER JOIN types t ON c.type_id = t.type_id ORDER BY 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->add($row);
            }
        }
    }

    public function deleteFromDatabaseByID($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM commands WHERE command_id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return true;
    }

    public function addToDatabase($conn, $params) {
        $stmt = $conn->prepare("INSERT INTO commands VALUES (DEFAULT, ?, ?, ?)");
        $name = $params['name'];
        $desc = $params['description'];
        $type = $params['type'];
        $stmt->bind_param("sss", $name, $desc, $type);
        $stmt->execute();
        return true;
    }

    public function updateDatabaseRow($conn, $params) {
        $stmt = $conn->prepare("UPDATE commands SET com_name = ?, description = ?, type_id = ? WHERE command_id = ?");
        $name = $params['name'];
        $desc = $params['description'];
        $type = $params['type'];
        $id = $params['id'];
        $stmt->bind_param("ssss", $name, $desc, $type, $id);
        $stmt->execute();
        return true;
    }
}
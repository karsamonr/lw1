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
        $result = array(['name', 'description', 'type', 'type_id', 'example']);
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
    
    public function exportAsDropdownItems($activeItem) {
        $result = '';
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            $result .= '<option '.($activeItem == $itemData['name'] ? 'selected' : '').' value="'.$itemData['id'].'">'.$itemData['name'].'</option>';
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
        $sql = "SELECT c.command_id id, c.com_name name, c.description, t.type_name type, c.type_id FROM commands c INNER JOIN types t ON c.type_id = t.type_id ORDER BY 1";
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
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['name'] == $params['name'] && $itemData['description'] == $params['description'] && $itemData['type_id'] == $params['type_id']) {
                return false;
            }
        }
        $stmt = $conn->prepare("INSERT INTO commands VALUES (DEFAULT, ?, ?, ?)");
        $name = $params['name'];
        $desc = $params['description'];
        $type_id = $params['type_id'];
        $stmt->bind_param("sss", $name, $desc, $type_id);
        $stmt->execute();
        return true;
    }

    public function updateDatabaseRow($conn, $params) {
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['name'] == $params['name'] && $itemData['description'] == $params['description'] && $itemData['type_id'] == $params['type_id'] && $itemData['id'] != $params['id']) {
                return false;
            }
        }
        $stmt = $conn->prepare("UPDATE commands SET com_name = ?, description = ?, type_id = ? WHERE command_id = ?");
        $name = $params['name'];
        $desc = $params['description'];
        $type_id = $params['type_id'];
        $id = $params['id'];
        $stmt->bind_param("ssss", $name, $desc, $type_id, $id);
        $stmt->execute();
        return true;
    }

    public function getBySearchQuery($conn, $query) {
        $stmt = $conn->prepare("
            SELECT c.command_id, c.com_name, c.description, t.type_name, c.type_id 
            FROM commands c 
            INNER JOIN types t ON c.type_id = t.type_id 
            WHERE c.com_name LIKE CONCAT ('%',?,'%') 
            OR c.description LIKE CONCAT ('%',?,'%')
            OR t.type_name LIKE CONCAT ('%',?,'%')
            ORDER BY 1");
        $stmt->bind_param("sss", $query, $query, $query);
        $stmt->execute();
        $stmt->store_result();
        $id = null; $name = null; $description = null; $type = null; $type_id = null;
        $stmt->bind_result($id, $name, $description, $type, $type_id);
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch()) {
                $row = array();
                $row['id'] = $id;
                $row['name'] = $name;
                $row['description'] = $description;
                $row['type'] = $type;
                $row['type_id'] = $type_id;
                $this->add($row);
            }
        }
    }
}
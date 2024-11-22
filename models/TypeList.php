<?php
require_once('../models/BaseList.php');
require_once('../models/Type.php');

class TypeList extends BaseList {
    public function add($params) {
        if (isset($params['id'])) {
            $this->id++;
        } else {
            $this->id++;
            $params['id'] = $this->id;
        }
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

    public function getFromDatabase($conn) {
        $sql = "SELECT type_id id, type_name name FROM types ORDER BY 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->add($row);
            }
        }
    }

    public function deleteFromDatabaseByID($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM types WHERE type_id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return true;
    }

    public function addToDatabase($conn, $params) {
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['name'] == $params['name']) {
                return false;
            }
        }
        $stmt = $conn->prepare("INSERT INTO types VALUES (DEFAULT, ?)");
        $name = $params['name'];
        $stmt->bind_param("s", $name);
        $stmt->execute();
        return true;
    }

    public function updateDatabaseRow($conn, $params) {
        foreach ($this->dataArray as $item) {
            $itemData = $item->getAsAssocArray();
            if ($itemData['name'] == $params['name'] && $itemData['id'] != $params['id']) {
                return false;
            }
        }
        $stmt = $conn->prepare("UPDATE types SET type_name = ? WHERE type_id = ?");
        $name = $params['name'];
        $id = $params['id'];
        $stmt->bind_param("ss", $name, $id);
        $stmt->execute();
        return true;
    }

    public function getBySearchQuery($conn, $query) {
        $stmt = $conn->prepare("SELECT type_id, type_name FROM types WHERE type_name LIKE CONCAT ('%', ?, '%') ORDER BY 1");
        $stmt->bind_param("s", $query);
        $stmt->execute();
        $stmt->store_result();
        $id = null; $name = null;
        $stmt->bind_result($id, $name);
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch()) {
                $row = array();
                $row['id'] = $id;
                $row['name'] = $name;
                $this->add($row);
            }
        }
    }
}
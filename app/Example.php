<?php
class Example {
    private $id;
    private $exampleCode;

    public function __construct($params) {
        $this->id=$params['id'];
        $this->exampleCode=$params['exampleCode'];
    }

    public function __destruct() {
        $this->id=null;
        $this->exampleCode=null;
    }

    public function update($params) {
        if (isset($params['id'])) {
            $this->id=$params['id'];
        }
        if (isset($params['exampleCode'])) {
            $this->exampleCode=$params['exampleCode'];
        }
    }

    public function displayInfo() {
        echo '<b>'.$this->id.'</b>. '.$this->exampleCode.'</br>';
    }

    public function getId() {
        return $this->id;
    }

    public function getAsArray() {
        return array($this->exampleCode);
    }

    public function getAsAssocArray() {
        return array('id'=>$this->id, 'exampleCode'=>$this->exampleCode);
    }

    public function getAsTableRow() {
        return '<tr>
                    <td>'.$this->id.'</td>
                    <td>'.$this->exampleCode.'</td>
                    <td><a class="btn btn-secondary btn-sm" href="add-example.php?id='.$this->id.'">Змінити</a><a class="btn btn-secondary btn-sm" href="example-list.php?action=delete&id='.$this->id.'">Видалити</a></td>
                </tr>';
    }
}
const commandTableContainer = document.querySelector('#commandsTable tbody');
const typeTableContainer = document.querySelector('#typesTable tbody');
const exampleTableContainer = document.querySelector('#examplesTable tbody');

const commandForm = document.getElementById('commandForm');
const typeForm = document.getElementById('typeForm');
const exampleForm = document.getElementById('exampleForm');

const commandRow = document.getElementById('commandRow');
const typeRow = document.getElementById('typeRow');
const exampleRow = document.getElementById('exampleRow');

const navMenu = document.getElementById('navMenu');
const loginRow = document.getElementById('loginRow');

let commandData = {};
let typeData = {};
let exampleData = {};

fetch("http://localhost/labs/lab4/api/profile.php").then(res => res.json())
.then(data => {
    if (data['login'] == true) {
        navMenu.style.display = 'flex';
        loginRow.style.display = 'none';
    } else {
        navMenu.style.display = 'none';
        loginRow.style.display = 'block';
        commandRow.style.display = "none";
        typeRow.style.display = "none";
        exampleRow.style.display = "none";
    }
});

function displayCommand() {
    fetch("http://localhost/labs/lab4/api/command-json.php").then(res => res.json())
    .then(data => {
        commandData = data;
        let content = ``;
        for (i = 0; i < data.length; i++) {
            content += `<tr>
            <td>`+data[i]['id']+`</td>
            <td>`+data[i]['name']+`</td>
            <td>`+data[i]['description']+`</td>
            <td>`+data[i]['type']+`</td>
            <td>`+data[i]['example']+`</td>
            <td><a href="#" class="edit-command btn btn-secondary btn-sm" data-id="`+data[i]['id']+`">Змінити</a>
            <a href="#" class="delete-command btn btn-secondary btn-sm" data-id="`+data[i]['id']+`">Видалити</a></td>
            </tr>`;
        }
        commandTableContainer.innerHTML = content;
    });
}

function displayTypes() {
    fetch("http://localhost/labs/lab4/api/type-json.php").then(res => res.json())
    .then(data => {
        typeData = data;
        let content = ``;
        for (i = 0; i < data.length; i++) {
            content += `<tr>
            <td>`+data[i]['id']+`</td>
            <td>`+data[i]['name']+`</td>
            <td><a href="#" class="edit-type btn btn-secondary btn-sm" data-id="`+data[i]['id']+`">Змінити</a>
            <a href="#" class="delete-type btn btn-secondary btn-sm" data-id="`+data[i]['id']+`">Видалити</a></td>
            </tr>`;
        }
        typeTableContainer.innerHTML = content;
    });
}

function displayExamples() {
    fetch("http://localhost/labs/lab4/api/example-json.php").then(res => res.json())
    .then(data => {
        exampleData = data;
        let content = ``;
        for (i = 0; i < data.length; i++) {
            content += `<tr>
            <td>`+data[i]['id']+`</td>
            <td>`+data[i]['exampleCode']+`</td>
            <td><a href="#" class="edit-example btn btn-secondary btn-sm" data-id="`+data[i]['id']+`">Змінити</a>
            <a href="#" class="delete-example btn btn-secondary btn-sm" data-id="`+data[i]['id']+`">Видалити</a></td>
            </tr>`;
        }
        exampleTableContainer.innerHTML = content;
    });
}

displayCommand();
displayTypes();
displayExamples();

document.addEventListener('submit', function(e) {
    if (e.target.id == "commandForm") {
        e.preventDefault();
        let formId = document.querySelector('#commandForm input[name="itemId"]').value;
        let formName = document.querySelector('#commandForm input[name="name"]').value;
        let formDesc = document.querySelector('#commandForm input[name="description"]').value;
        let formType = document.querySelector('#commandForm input[name="type"]').value;
        let formEx = document.querySelector('#commandForm input[name="example"]').value;
        if (formId == "") {
            let data = JSON.stringify({"name":formName, "description":formDesc, "type":formType, "example":formEx});
            fetch("http://localhost/labs/lab4/api/command-json.php", {
                method: "POST",
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json'
                },
                body: data
            })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayCommand();
                commandForm.reset();
                document.querySelector('#commandForm input[name="itemId"]').value = "";
            });
        } else {
            let data = JSON.stringify({"id":formId, "name":formName, "description":formDesc, "type":formType, "example":formEx});
            fetch("http://localhost/labs/lab4/api/command-json.php", {
                method: "PUT",
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json'
                },
                body: data
            })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayCommand();
                commandForm.reset();
                document.querySelector('#commandForm input[name="itemId"]').value = "";
            });
        }
    }
    if (e.target.id == "typeForm") {
        e.preventDefault();
        let formId = document.querySelector('#typeForm input[name="itemId"]').value;
        let formName = document.querySelector('#typeForm input[name="name"]').value;
        if (formId == "") {
            let data = JSON.stringify({"name":formName});
            fetch("http://localhost/labs/lab4/api/type-json.php", {
                method: "POST",
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json'
                },
                body: data
            })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayTypes();
                typeForm.reset();
                document.querySelector('#typeForm input[name="itemId"]').value = "";
            });
        } else {
            let data = JSON.stringify({"id":formId, "name":formName});
            fetch("http://localhost/labs/lab4/api/type-json.php", {
                method: "PUT",
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json'
                },
                body: data
            })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayTypes();
                typeForm.reset();
                document.querySelector('#typeForm input[name="itemId"]').value = "";
            });
        }
    }   
    if (e.target.id == "exampleForm") {
        e.preventDefault();
        let formId = document.querySelector('#exampleForm input[name="itemId"]').value;
        let formCode = document.querySelector('#exampleForm input[name="exampleCode"]').value;
        if (formId == "") {
            let data = JSON.stringify({"exampleCode":formCode});
            fetch("http://localhost/labs/lab4/api/example-json.php", {
                method: "POST",
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json'
                },
                body: data
            })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayExamples();
                exampleForm.reset();
                document.querySelector('#exampleForm input[name="itemId"]').value = "";
            });
        } else {
            let data = JSON.stringify({"id":formId, "exampleCode":formCode});
            fetch("http://localhost/labs/lab4/api/example-json.php", {
                method: "PUT",
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json'
                },
                body: data
            })
            .then(function(res){ return res.json(); })
            .then(function(data){ 
                displayExamples();
                exampleForm.reset();
                document.querySelector('#exampleForm input[name="itemId"]').value = "";
            });
        }
    }
    if (e.target.id == "loginForm") {
        e.preventDefault();
        let formLogin = document.querySelector('#loginForm input[name="login"]').value;
        let formPassword = document.querySelector('#loginForm input[name="password"]').value;
        let data = JSON.stringify({"login":formLogin, "password":formPassword});
        fetch("http://localhost/labs/lab4/api/profile.php", {
            method: "POST",
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
            body: data
        })
        .then(function(res){ return res.json(); })
        .then(function(data){ 
            if (data['login'] == true) {
                navMenu.style.display = 'flex';
                loginRow.style.display = 'none';
            } else {
                navMenu.style.display = 'none';
                loginRow.style.display = 'block';
                commandRow.style.display = "none";
                typeRow.style.display = "none";
                exampleRow.style.display = "none";
            }
        });
        
    }
}, false);

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('edit-command')) {
        e.preventDefault();
        for (let i = 0; i < commandData.length; i++) {
            if (commandData[i]['id'] == e.target.getAttribute('data-id')) {
                let itemData = commandData[i];
                document.querySelector('#commandForm input[name="itemId"]').value = itemData['id'];
                document.querySelector('#commandForm input[name="name"]').value = itemData['name'];
                document.querySelector('#commandForm input[name="description"]').value = itemData['description'];
                document.querySelector('#commandForm input[name="type"]').value = itemData['type'];
                document.querySelector('#commandForm input[name="example"]').value = itemData['example'];
            }
        }
    } else if (e.target.classList.contains('delete-command')) {
        e.preventDefault();
        let data = JSON.stringify({"id":e.target.getAttribute('data-id')});
        fetch("http://localhost/labs/lab4/api/command-json.php", {
            method: "DELETE",
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
            body: data
        })
        .then(function(res){ return res.json(); })
        .then(function(data){ 
            displayCommand();
        });
    } else if (e.target.classList.contains('edit-type')) {
        e.preventDefault();
        for (let i = 0; i < typeData.length; i++) {
            if (typeData[i]['id'] == e.target.getAttribute('data-id')) {
                let itemData = typeData[i];
                document.querySelector('#typeForm input[name="itemId"]').value = itemData['id'];
                document.querySelector('#typeForm input[name="name"]').value = itemData['name'];
            }
        }
    } else if (e.target.classList.contains('delete-type')) {
        e.preventDefault();
        let data = JSON.stringify({"id":e.target.getAttribute('data-id')});
        fetch("http://localhost/labs/lab4/api/type-json.php", {
            method: "DELETE",
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
            body: data
        })
        .then(function(res){ return res.json(); })
        .then(function(data){ 
            displayTypes();
        });
    } else if (e.target.classList.contains('edit-example')) {
        e.preventDefault();
        for (let i = 0; i < exampleData.length; i++) {
            if (exampleData[i]['id'] == e.target.getAttribute('data-id')) {
                let itemData = exampleData[i];
                document.querySelector('#exampleForm input[name="itemId"]').value = itemData['id'];
                document.querySelector('#exampleForm input[name="exampleCode"]').value = itemData['exampleCode'];
            }
        }
    } else if (e.target.classList.contains('delete-example')) {
        e.preventDefault();
        let data = JSON.stringify({"id":e.target.getAttribute('data-id')});
        fetch("http://localhost/labs/lab4/api/example-json.php", {
            method: "DELETE",
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            },
            body: data
        })
        .then(function(res){ return res.json(); })
        .then(function(data){ 
            displayExamples();
        });
    } else if (e.target.id == "commandBtn") {
        e.preventDefault();
        commandRow.style.display = "flex";
        typeRow.style.display = "none";
        exampleRow.style.display = "none";
    } else if (e.target.id == "typeBtn") {
        e.preventDefault();
        commandRow.style.display = "none";
        typeRow.style.display = "flex";
        exampleRow.style.display = "none";
    } else if (e.target.id == "exampleBtn") {
        e.preventDefault();
        commandRow.style.display = "none";
        typeRow.style.display = "none";
        exampleRow.style.display = "flex";
    } else if (e.target.id == "logoutBtn") {
        e.preventDefault();
        fetch("http://localhost/labs/lab4/api/profile.php?action=logout", )
        .then(function(res){ return res.json(); })
        .then(function(data){ 
            navMenu.style.display = 'none';
            loginRow.style.display = 'block';
            commandRow.style.display = "none";
            typeRow.style.display = "none";
            exampleRow.style.display = "none";
        });
    }
}, false);
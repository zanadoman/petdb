let pets = [];

function init() {
    GET();


}

function GET() {
    let xhr = new XMLHttpRequest();

    xhr.open(`GET`, `http://localhost/api.php`);
    xhr.onload = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            JSON.parse(xhr.response).data.forEach(element => pets.push(element));
        }

        console.log(`GET: RESPONSE: ${xhr.status}`);
    }

    xhr.send(null);
}

function DELETE(id) {
    let xhr = new XMLHttpRequest();

    xhr.open(`DELETE`, `http://localhost/api.php?id=${id}`);
    xhr.onload = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            window.alert(`Sikeres törlés`);
        } else {
            window.alert(`Sikertelen törlés`);
        }

        console.log(`DELETE: id=${id} + " RESPONSE: " + ${xhr.status}`);
    }

    xhr.send(null);
}

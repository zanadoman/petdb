function init() {
    GET_pets();
    GET_species();
}

function fill_pets(pets) {
    let content = document.getElementById(`pets`);

    pets.forEach(element => 
        content.innerHTML += `
            <tr>
                <td>${element.name}</td>
                <td>${element.species}</td>
                <td style="width: 15vw;">
                    <img src="${element.image}" style="width: 15vw;">
                </td>
                <td style="width: 6vw;">
                    <input type="button" onclick="PUT(${element.id})" value="Módosítás">
                    <br>
                    <input type="button" onclick="DELETE(${element.id})" value="Törlés">
                </td>
            </tr>
        `
    );
}

function fill_species(species) {
    let content = document.getElementById(`species`);

    species.forEach(element =>
        content.innerHTML += `
            <input type="radio" name="species_id" value="${element.id}" required>
            <label>${element.name}</label><br>
        `
    );
}

function GET_pets() {
    let xhr = new XMLHttpRequest();

    xhr.open(`GET`, `http://localhost/api.php?pets`);
    xhr.onload = function() {
        if (xhr.readyState !== 4) {
            return;
        }

        switch (xhr.status) {
            case 200:
                fill_pets(JSON.parse(xhr.response));
            break;

            case 400:
                window.alert(`Érvénytelen kérés`);
            break;

            case 401:
                window.alert(`Érvénytelen munkament`);
            break;

            case 403:
                window.alert(`Hozzáférés megtagadva`);
            break;

            case 500:
                window.alert(`Szerver hiba`);
            break;

            default:
                window.alert(`Ismeretlen hiba`);
            break;
        }

        console.log(`GET: ${xhr.status}`);
    }

    xhr.send();
}

function GET_species() {
    let xhr = new XMLHttpRequest();

    xhr.open(`GET`, `http://localhost/api.php?species`);
    xhr.onload = function() {
        if (xhr.readyState !== 4) {
            return;
        }

        switch (xhr.status) {
            case 200:
                fill_species(JSON.parse(this.response));
            break;

            case 400:
                window.alert(`Érvénytelen kérés`);
            break;

            case 401:
                window.alert(`Érvénytelen munkament`);
            break;

            case 403:
                window.alert(`Hozzáférés megtagadva`);
            break;

            case 500:
                window.alert(`Szerver hiba`);
            break;

            default:
                window.alert(`Ismeretlen hiba`);
            break;
        }

        console.log(`GET: ${xhr.status}`);
    }

    xhr.send();
}

function POST() {
    let xhr = new XMLHttpRequest();

    xhr.open(`POST`, `http://localhost/api.php`);
    xhr.onload = function() {
        if (xhr.readyState !== 4) {
            return;
        }

        switch (xhr.status) {
            case 200:
                window.alert("Sikeres hozzáadás");
                location.reload();
            break;

            case 400:
                window.alert(`Érvénytelen kérés`);
            break;

            case 401:
                window.alert(`Érvénytelen munkament`);
            break;

            case 403:
                window.alert(`Hozzáférés megtagadva`);
            break;

            case 500:
                window.alert(`Szerver hiba`);
            break;

            default:
                window.alert(`Ismeretlen hiba`);
            break;
        }

        console.log(`POST: ${xhr.status}`);
    }

    xhr.send(new FormData(document.getElementById(`new`)));
}

function PUT(id) {
    let xhr = new XMLHttpRequest();

    xhr.open(`PUT`, `http://localhost/api.php`);
    xhr.onload = function() {
        if (xhr.readyState !== 4) {
            return;
        }

        switch (xhr.status) {
            case 200:
                window.alert("Sikeres módosítás");
                location.reload();
            break;

            case 400:
                window.alert(`Érvénytelen kérés`);
            break;

            case 401:
                window.alert(`Érvénytelen munkament`);
            break;

            case 403:
                window.alert(`Hozzáférés megtagadva`);
            break;

            case 422:
                window.alert(`Hibás adat(ok)`);
            break;

            case 500:
                window.alert(`Szerver hiba`);
            break;

            default:
                window.alert(`Ismeretlen hiba`);
            break;
        }

        console.log(`DELETE: " + ${xhr.status}`);
    }

    xhr.send(JSON.stringify({
        id: id,
        name: prompt(`Név:`),
        species_name: prompt(`Faj:`),
        image: prompt(`Kép url:`)
    }));
}

function DELETE(id) {
    let xhr = new XMLHttpRequest();

    xhr.open(`DELETE`, `http://localhost/api.php?id=${id}`);
    xhr.onload = function() {
        if (xhr.readyState !== 4) {
            return;
        }

        switch (xhr.status) {
            case 200:
                window.alert("Sikeres törlés");
                location.reload();
            break;

            case 400:
                window.alert(`Érvénytelen kérés`);
            break;

            case 401:
                window.alert(`Érvénytelen munkament`);
            break;

            case 403:
                window.alert(`Hozzáférés megtagadva`);
            break;

            case 500:
                window.alert(`Szerver hiba`);
            break;

            default:
                window.alert(`Ismeretlen hiba`);
            break;
        }

        console.log(`DELETE: " + ${xhr.status}`);
    }

    xhr.send();
}

let dropdowns = document.querySelectorAll('.dynamic');
for (let dropdown of dropdowns) {
    dropdown.addEventListener('change', insertFetched);
}

let start_dropdowns = document.querySelectorAll('.dynamic-start');
for (let dropdown of start_dropdowns) {
    insertFetched.apply(dropdown);
}

function addScript() {
    if (document.querySelector('input[name="script"]')) {
        let script = document.createElement("script");  // create a script DOM node
        script.src = document.querySelector('input[name="script"]').value;  // set its src to the provided URL
        document.querySelector('table').appendChild(script);
    }
}

function fetchDat() {
    let path = new URL(window.location.href);
    path = path.pathname+'/fetch';

    fetch(path, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        },
        body: new FormData(document.forms.fetch),
    })
        .then(response => response.text())
        .then(result => {
            if (document.querySelector('input[name="header"]')) {
                document.querySelector('table').innerHTML = result;
            } else {
                document.querySelector('tbody').innerHTML = result;
            }
            //console.log(result);
            addScript();
        })
}

// Получить и обработать результаты
// Promise.all если несколько дочерних
// Рекурсией запускаем для всех дочерних динамических
function insertFetched() {
    let values = getDropdownsValues();
    // Если только один селект
    if (this.dataset.dependant) {
        let submit = document.querySelector('button[type="submit"]');
        if (submit) {
            let submits = document.querySelectorAll('button[type="submit"]');
            for (let submit of submits) {
                submit.disabled = true;
            }
        }
        let paths = this.dataset.dependant.split(', ');
        let promises = Promise.all(makeRequests(values, paths))
            .then(responses => Promise.all(responses.map(r => r.text())))
            .then(results => results.forEach((result, index) => {
                let dropdown = document.getElementById(paths[index]);
                dropdown.innerHTML = result;
                if (dropdown.classList.contains('dynamic')) {
                    insertFetched.apply(dropdown);
                }

                if (dropdown.classList.contains('dynamic-end')) {
                    if (submit) {
                        let submits = document.querySelectorAll('button[type="submit"]');
                        for (let submit of submits) {
                            submit.disabled = false;
                        }
                    }
                }
                // Если нужно вывести таблицу
                if (dropdown.classList.contains('dynamic-fetch')) {
                    dropdown.addEventListener('change', fetchDat);
                    fetchDat();
                }
            }));
     } else {
        fetchDat();
    }
}

// Сделать запрос
function makeRequests(values, paths) {
    return paths.map(path => {
        let url = makeURL(path);
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: JSON.stringify({
                values: values,
                dependant: path,
            }),
        });
    })
}

// Получить значения всех выпадающих списков
function getDropdownsValues() {
    let dropdowns = document.querySelectorAll('.dynamic');
    let values = [];
    for (let dropdown of dropdowns) {
        values.push(dropdown.value);
    }
    return values;
}

// Создать путь для запроса
function makeURL(path) {
    let url = new URL(window.location.href);
    url = url.pathname.split('/');
    url.pop();
    url.push('fetch-' + path);
    url = url.join('/');
    //console.log(url);
    return url;
}

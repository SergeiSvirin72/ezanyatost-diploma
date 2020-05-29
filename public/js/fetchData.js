addThListenters();
addPaginationListeners();
addDeleteListeners();
addFormListeners();

function addScript() {
    if (document.querySelector('input[name="script"]')) {
        let script = document.createElement("script");  // create a script DOM node
        script.src = document.querySelector('input[name="script"]').value;  // set its src to the provided URL
        document.querySelector('table').appendChild(script);
    }
}

function addThListenters() {
    if (document.querySelector('.sorting')) {
        let tds = document.querySelectorAll('.sorting');
        for (let td of tds) {
            td.addEventListener('click', function () {
                let sort_type = this.dataset.sort_type;
                let column_name = this.dataset.column_name;

                clearIcons();

                if (sort_type === 'asc') {
                    this.dataset.sort_type = 'desc';
                    document.getElementById(column_name + '_icon').innerHTML = '<i class=\"fas fa-angle-down\"></i>';

                }
                if (sort_type === 'desc') {
                    this.dataset.sort_type = 'asc';
                    document.getElementById(column_name + '_icon').innerHTML = '<i class=\"fas fa-angle-up\"></i>';
                }

                document.querySelector('input[name="column_name"]').value = column_name;
                document.querySelector('input[name="sort_type"]').value = sort_type;

                fetchData();
            });
        }
    }
}

function addDeleteListeners() {
    if (document.querySelector('.delete')) {
        let delete_buttons = document.querySelectorAll('.delete');
        for (let button of delete_buttons) {
            button.addEventListener('click', function () {
                if (confirm("Вы уверены, что хотите удалить запись?")) {
                    let path = new URL(window.location.href);
                    path = path.pathname + '/' + this.getAttribute("data");
                    //console.log(path);
                    fetch(path, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                    })
                        .then(response => response.text())
                        .then(result => {
                            //console.log(result);
                            fetchData();
                        });
                }
            });
        }
    }
}

function addPaginationListeners() {
    if (document.querySelector('.pagination a')) {
        let links = document.querySelectorAll('.pagination a');
        for (let link of links) {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                let page = this.href.split('page=')[1];
                document.querySelector('input[name="page"]').value = page;

                fetchData();
            });
        }
    }
}

function addFormListeners() {
    if (document.querySelector('input[name="begin"]')) {
        fetchData();
    }
    if (document.querySelector('button[name="export"]')) {
        document.querySelector('button[name="export"]')
            .addEventListener('click', function() {
                document.forms.fetch.removeEventListener('submit', formHandler);
                document.forms.fetch.submit();
                document.forms.fetch.addEventListener('submit', formHandler);
            })
    }
    document.forms.fetch.addEventListener('submit', formHandler);
    function formHandler(event) {
        fetchData();
        event.preventDefault();
    }
}

function clearIcons() {
    let tds = document.querySelectorAll('.sorting');
    for (let td of tds) {
        td.firstElementChild.innerHTML = '';
    }
}

function fetchData() {
    let path = new URL(window.location.href);
    path = path.pathname+'/fetch';
    //console.log(path);
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
            addDeleteListeners();
            addPaginationListeners();
            addScript();
        })
}

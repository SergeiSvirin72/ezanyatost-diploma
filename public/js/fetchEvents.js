document.addEventListener("DOMContentLoaded", function() {
    let dropdown = document.querySelector('.dynamic');
    dropdown.addEventListener('change', fetchEvents);

    function fetchEvents() {
        console.log(document.forms.fetch);
        fetch('/events/fetch', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: new FormData(document.forms.fetch),
        })
            .then(response => response.text())
            .then(result => {
                //console.log(result);
                document.querySelector('.card-deck').innerHTML = result;
                addPaginationListeners();
            });
    }

    function addPaginationListeners() {
        if (document.querySelector('.pagination a')) {
            let links = document.querySelectorAll('.pagination a');
            for (let link of links) {
                link.addEventListener('click', function (event) {
                    event.preventDefault();

                    let page = this.href.split('page=')[1];
                    document.querySelector('input[name="page"]').value = page;

                    window.scrollTo({
                        behavior: 'smooth',
                        top: 0
                    });

                    fetchEvents();
                });
            }
        }
    }

    fetchEvents();
});

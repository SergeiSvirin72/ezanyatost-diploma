document.addEventListener("DOMContentLoaded", function() {
    let dropdown = document.querySelector('.dynamic');
    dropdown.addEventListener('change', fetchSchedule);

    function fetchSchedule() {
        fetch('/organisations/schedule', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: new FormData(document.forms.schedule),
        })
            .then(response => response.text())
            .then(result => {
                //console.log(result);
                document.querySelector('.card-deck').innerHTML = result;
            });
    }

    fetchSchedule();
});


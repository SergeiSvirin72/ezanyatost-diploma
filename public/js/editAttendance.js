function editAttendance() {
    let cells = document.querySelectorAll('.table tbody tr .editable');
    for(let i = 0; i < cells.length; i++) {
        cells[i].addEventListener("click", addInput);
    }

    function addInput() {
        this.removeEventListener("click", addInput);
        //console.log(this.innerHTML);
        var temp = this.innerHTML;
        this.innerHTML = "";
        var input = document.createElement("input");
        input.type = "text";
        input.value = temp;
        input.addEventListener("blur", removeInput);

        setInputFilter(input, filterInputValue);

        this.appendChild(input);
        input.focus();
        input.setSelectionRange(0, input.value.length);
    }

    function removeInput() {
        let temp = this.value;
        let parent = this.parentNode;
        let params = buildInputAttr(parent.dataset);
        params.value = temp;
        updateValue('/admin/attendances/edit', params);
        this.remove();
        parent.innerHTML = temp;
        parent.addEventListener("click", addInput);
    }

    function updateValue(url, body) {
        //console.log(url, body);
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: JSON.stringify(body),
        })
            .then(response => response.text())
            .then(result => {console.log(result)})
    }

    function buildInputAttr(dataset) {
        let params = {};
        for (let key in dataset) {
            params[key] = dataset[key];
        }
        return params;
    }

    function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    this.value = "";
                }
            });
        });
    }

    function filterInputValue(value) {
        return /^[ПОУН]$/.test(value);
    }
}

editAttendance();


function back() {
    var current = parseInt(sessionStorage.getItem('current'), 10);
    var rewind = JSON.parse(sessionStorage.getItem('rewind'));
    if (current > 0) {
        var target = rewind[current - 1];
        if (target[1] != null) {
            for (i = 0; i < switchEmbed.length; i++) {
                if (switchEmbed[i].classList.contains('highlighted')) {
                    switchEmbed[i].classList.remove('highlighted');
                }
            }
            document.getElementsByName(target[1])[0].classList.add("highlighted");
        }
        AJAX(target[0], "mainEmbed", false);
        sessionStorage.setItem('current', (current - 1));
    }
}

function forward() {
    var current = parseInt(sessionStorage.getItem('current'), 10);
    var rewind = JSON.parse(sessionStorage.getItem('rewind'));
    if (current < rewind.length - 1) {
        var target = rewind[current + 1];
        if (target[1] != null) {
            for (i = 0; i < switchEmbed.length; i++) {
                if (switchEmbed[i].classList.contains('highlighted')) {
                    switchEmbed[i].classList.remove('highlighted');
                }
            }
            document.getElementsByName(target[1])[0].classList.add("highlighted");
        }
        AJAX(target[0], "mainEmbed", false);
        sessionStorage.setItem('current', (current + 1));
    }
}

function searchIndex() {
    let input, filter, table, tr, td, i, txtValue, searchBy;
    searchBy = document.getElementById("search-by");
    input = document.getElementById("search-list");
    filter = input.value.toUpperCase();
    table = document.getElementById("index");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        if (searchBy.value === "name") {
            td = tr[i].getElementsByTagName("td")[0];
            input.placeholder = "Search for names..";
        } else if (searchBy.value === "id") {
            td = tr[i].getElementsByTagName("td")[2];
            input.placeholder = "Search for ID..";
        } else if (searchBy.value === "status") {
            td = tr[i].getElementsByTagName("td")[3];
            input.placeholder = "Search for status..";
        }
        if (td) {
            txtValue = td.textContent || td.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            }else {
                tr[i].style.display = "none";
            }
        }
    }
}

function sortTable() {
    let table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("index");
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[0];
            y = rows[i + 1].getElementsByTagName("TD")[0];

            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

//Dark Mode Functionality
const dark_toggler = document.querySelector('.dark-toggler');
const prefersDark = window.matchMedia("(prefers-color-scheme: dark)");

const currentMode = localStorage.getItem("theme");
if (currentMode === "dark") { //TOP!!
    document.body.classList.toggle("dark-mode");
}
else if (currentMode === "light") {
    document.body.classList.toggle('light-mode');
}

dark_toggler.addEventListener("click", function () {
    let theme;
    if (prefersDark.matches) {
        document.body.classList.toggle("light-mode");
        theme = document.body.classList.contains('light-mode') ? "light" : "dark";
    } else {
        document.body.classList.toggle("dark-mode");
        theme = document.body.classList.contains('dark-mode') ? "dark" : "light";
    }

    //localStorage.setItem("theme", theme);
});

//enables various buttons to display information
const dropdown = document.getElementsByClassName("dropdown-button");
let i;

for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function () {
        this.classList.toggle("active");
        const dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
}
//async function to change embed data && selected button highlight
const switchEmbed = document.querySelectorAll('.sidenav button');

for (i = 0; i < switchEmbed.length; i++) {
    switchEmbed[i].addEventListener('click', function (e) {
        if (this.name !== "null") {
            //Reluctantly using a nestled for loop to check for highlights, and remove them.
            for (i = 0; i < switchEmbed.length; i++) {
                if (switchEmbed[i].classList.contains('highlighted')) {
                    switchEmbed[i].classList.remove('highlighted');
                }
            }
            this.classList.add("highlighted");
            const buttonName = this.name;
            const viewportTitle = document.getElementById('viewportTitle');
            viewportTitle.innerHTML = buttonName;

            if (e.target.value) {
                AJAX(e.target.value, "mainEmbed", true, this.name);

            }
        }
    })
}

function AJAX(target, element, rewnd = true, button = null, highlight = null) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (rewnd) {
                if (highlight != null) {
                    for (i = 0; i < switchEmbed.length; i++) {
                        if (switchEmbed[i].classList.contains('highlighted')) {
                            switchEmbed[i].classList.remove('highlighted');
                        }
                    }
                    document.getElementsByName(highlight)[0].classList.add("highlighted");
                }
                var url = this.responseURL;
                var parser = document.createElement("a");
                parser.href = url;
                var rewind = [];
                if (sessionStorage.getItem('rewind') === null && sessionStorage.getItem('current') === null) {
                    rewind.push([parser.pathname, button]);
                    sessionStorage.setItem('rewind', JSON.stringify(rewind));
                    sessionStorage.setItem('current', 0);
                } else {
                    var rewind = JSON.parse(sessionStorage.getItem('rewind'));
                    var current = rewind.length;
                    rewind.push([parser.pathname, button])
                    sessionStorage.setItem('rewind', JSON.stringify(rewind));
                    sessionStorage.setItem('current', (current));
                }
            }
            document.getElementById(element).innerHTML = this.response;
        }
    };
    xhttp.open("GET", target, true);
    xhttp.send();
}

//get post data from form and send to server

function postData(int) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("form").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", "/accountTools/student/make.php?userData=" + int, true);
    xmlhttp.send();
}

//closes the dropdown menu when the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropdown-button')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        let i;
        for (i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.style.display === "block") {
                openDropdown.style.display = "none";
            }
        }
    }
}
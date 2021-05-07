if ( window.history.replaceState ) {window.history.replaceState( null, null, window.location.href );}
function openForm(a, b) {
    if (document.getElementById(a).style.display == "block") {
        document.getElementById(a).style.display = "none"
    } else {
        document.getElementById(a).style.display = "block";
    }
    document.getElementById(b).style.display = "none"
}

function closeForm(f) {
    document.getElementById(f).style.display = "none";
}



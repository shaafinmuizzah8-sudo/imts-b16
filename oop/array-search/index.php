<div>
    <form action="">
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname" onkeyup="ajxCall(this.value);">
    </form>
    <p>Suggestions: <span id="txtHint"></span></p>
</div>

<script>
    function ajxCall(str) {
        console.log(str.length);
        if (str.length == 0) {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            httpRequest = new XMLHttpRequest();
            httpRequest.open("GET", "hint.php?q=" + str, true);
            httpRequest.send();

            httpRequest.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                } else {
                    document.getElementById("txtHint").innerHTML = "Error: " + this.status;
                    return;
                }
            };
        }
    }
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/print.css">
</head>
<body>
    <div class="page-container">
        <div class="page" id="1">
            <thead>Test header</thead>

            <h1>Hello world!</h1>

            <tfoot>Test footer</tfoot>
        </div>

        <div class="page" id="2">
            <header>Test Headder</header>

            <h1>Good Bye</h1>

            <footer>test footer</footer>
        </div>

        <div class="page" id="3">
            <header>Test Headder</header>

            <h1>test Bye</h1>

            <footer>test footer</footer>
        </div>
    </div>

    <div class="no-print">
        <button onclick="window.print()">Print All</button>

        <div>
            <label for="print-selection">Print One:</label>
            <select name="print-selection" id="selection">
                <option value="">>-- Select --<</option>
                <option value="1">Page One</option>
                <option value="2">Page Two</option>
                <option value="3">Page Three</option>
            </select>
            <button type="submit" onclick="printSelected()">Print</button>
        </div>

        <div>
            <label for="print-from">Print from:</label>
            <select name="print-selection" id="selection" required>
                <option value="">>-- Select --<</option>
                <option value="1">Page One</option>
                <option value="2">Page Two</option>
            </select>
            <br>
            <label for="print-to">Print to:</label>
            <select name="print-selection" id="selection" required>
                <option value="">>-- Select --<</option>
                <option value="1">Page One</option>
                <option value="2">Page Two</option>
            </select> <button onclick="printSelected()">Print</button>
        </div>
    </div>

    <script>
        function printSelected(){
            let selection = document.getElementById("selection").value;

            if (selection === "") {
                return;
            }

            let page = document.getElementById(selection);

            let WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write('<link rel=stylesheet href=css/print.css>');
            WinPrint.document.write(page.innerHTML);
            WinPrint.document.write('<script>print()<\/script>');
            WinPrint.close();
            location.reload();
        }
    </script>
</body>
</html>
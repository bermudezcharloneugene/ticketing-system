<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>
<body>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col-sm-1 col-md-1">
            <select name="" id="display" class="form-control">
                <option value="5" selected>5</option>
                <option value="5">10</option>
                <option value="5">15</option>
            </select>
            </div>

        </div>
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-stripped" id="ticket_id" data-pagecount="10">
                <caption>Lists of Tickets</caption>
                <thead class="thead-dark">
                    <tr class="">
                        <th>No.</th>
                        <th>Environment</th>
                        <th>Type</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Root Cause</th>
                        <th>Solution</th>
                        <th>Reported Date</th>
                        <th>Status</th>
                        <th>Responsible Unit</th>
                        <th>Assigned</th>
                        <th>QA</th>
                        <th>Implemented</th>
                        <th>Affected Files</th>
                        <th>Remarks</th>                    
                    </tr>
                </thead>
                <tbody class="text-right" id="body">

                </tbody>
            </table>
        </div>
        <nav class="mt-3 d-flex justify-content-center" aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script >
        $(document).ready(function() {
            
            let display = $('#display').val();
            let tables = $('#ticket_id');
            let pagination = $('.pagination');
            let pageLink = $('.page-link').val();
            const getData = async () => {
                let send = await fetch('http://localhost/ticketing_system2/app/controls/TicketsController.php')
                .then(res => res.json());
                return send;
            }
  
            getData().then(data => {
                showTables(data, 5, 2);
                console.log(data)
            })

            const showTables = (tickets, perPage, page) => {
                page--;
                let start = perPage * page;
                let end = start + page;
                let paginatedItems = tickets.slice(start, end);
                console.log(paginatedItems)
                paginatedItems.map(ticket => {
                    tables.append('<tr>'+'<td>'+ ticket.TICKET_NAME + '</td>'+'<td>'+ ticket.TICKET_DESCRIPTION + '</td>'+ '<td>'+ ticket.TYPE_NAME + '</td>'+'</tr>')
                })
            }

            function genTables() {
                
                for (var i = 0; i < tables.length; i++) 
                {
                    perPage = parseInt(tables[i].dataset.pagecount);
                    createFooters(tables[i]);
                    createTableMeta(tables[i]);
                    loadTable(tables[i]);
                }
            }

    // based on current page, only show the elements in that range
    // function loadTable(table) {
    //     var startIndex = 0;
    
    //     if (table.querySelector('th'))
    //         startIndex = 1;
    
    // 	console.log(startIndex);
    
    //     var start = (parseInt(table.dataset.currentpage) * table.dataset.pagecount) + startIndex;
    //     var end = start + parseInt(table.dataset.pagecount);
    //     var rows = table.rows;
    
    //     for (var x = startIndex; x < rows.length; x++) {
    //         if (x < start || x >= end)
    //             rows[x].classList.add("inactive");
    //         else
    //             rows[x].classList.remove("inactive");
    //     }
    // }
    // function createTableMeta(table) {
    //     table.dataset.currentpage = "0";
    // }
    // function createFooters(table) {
    //     var hasHeader = false;
    //     if (table.querySelector('th'))
    //         hasHeader = true;
    
    //     var rows = table.rows.length;
    
    //     if (hasHeader)
    //         rows = rows - 1;
    
    //     var numPages = rows / perPage;
    //     var pager = document.createElement("div");

        // if (numPages % 1 > 0)
        //     numPages = Math.floor(numPages) + 1;
    
        // pager.className = "pager";
        // for (var i = 0; i < numPages ; i++) {
        //     var page = document.createElement("div");
        //     page.innerHTML = i + 1;
        //     page.className = "pager-item";
        //     page.dataset.index = i;
        
        //     if (i == 0)
        //         page.classList.add("selected");
        
        //     page.addEventListener('click', function() {
        //         var parent = this.parentNode;
        //         var items = parent.querySelectorAll(".pager-item");
        //         for (var x = 0; x < items.length; x++) {
        //             items[x].classList.remove("selected");
        //         }
        //         this.classList.add('selected');
        //         table.dataset.currentpage = this.dataset.index;
        //         loadTable(table);
        //     });
        //     pager.appendChild(page);
        // }
    

        // table.parentNode.insertBefore(pager, table);
    // }
           
})
    </script>
</body>
</html>
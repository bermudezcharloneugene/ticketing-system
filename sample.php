<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
    <div class="container mt-5">
        <div class="text-center f1 mb-3">
            <h3>Dashboard</h3>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="ticketGraph"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="ticketGraphLine"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="container d-flex flex-md-row justify-content-center"> -->
            <div class="card">
                <div class="card-body">
                    <canvas id="ticketGraphArea"></canvas>
                </div>
            </div>
        <!-- </div> -->
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="./node_modules/chart.js/dist/Chart.min.js"></script>
<script type="application/javascript" >
$(document).ready(function (){
    let open = [];
    let closed = [];
    let progress = [];
    let labels = ['Open','In Progress', 'Closed'];
    let type1 = [];
    let type2 = [];
    let type3 = [];


    let arraySet = (arr) => {
        for(var i in arr)
        {
            if(arr[i].TICKET_STATUS_ID === "1")
            {
                open.push("data" + i);
            }
            if(arr[i].TICKET_STATUS_ID === "2")
            {
                progress.push("data" + i);
            }
            if(arr[i].TICKET_STATUS_ID === "3")
            {
                closed.push("data" + i);
            }
            if(arr[i].TYPE_NAME === "INCIDENT")
            {
                type1.push("data" + i);
            }
            if(arr[i].TYPE_NAME === "ISOLATED INCIDENT")
            {
                type2.push("data" + i);
            }
            if(arr[i].TYPE_NAME === "REQUEST")
            {
                type3.push("data" + i);
            }
        
        }
        let openData = [];
        openData.push(open.length);
        let progressData = [];
        progressData.push(progress.length)
        let closedData = [];
        closedData.push(closed.length);
        

        console.log(open.length);
        const chartdata = {
            labels: labels,
            datasets : [
                {
                  label: 'Tickets',
                  backgroundColor: [
                    'rgb(34,139,34)',
                    'rgba(173, 216, 230)',
                    'rgba(255, 99, 132, 0.2)',
                  ],
                  borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(173, 216, 230)',
                    'rgba(255,99,132,1)',
                  ],
                  data: [openData[0], progressData[0], closedData[0]],
                },
            
            ],
        };

        const linedata = {
            labels: ['INCIDENTS', 'ISOLATED INCIDENTS', 'REQUESTS'],
            datasets : [
                {
                  label: ['INCIDENTS'],
                  data: [type1.length, type2.length, type3.length],
                },
            
            ],
        };

        const option = {
            scales : {
                xAxes: [{
                    stacked: true
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }



        const ctx1 = document.getElementById('ticketGraph').getContext('2d');
        
        const barGraph = new Chart(ctx1, {
            type: 'bar',
            data: chartdata,
            options: option
        });

        const ctx2 = document.getElementById('ticketGraphLine').getContext('2d');
    
        const barGraph2 = new Chart(ctx2, {
            type: 'line',
            data: linedata,
            options: {
                scales: {
                    yAxes: [{
                        stacked: false
                    }]
                }
            }
        });

        const ctx3 = document.getElementById('ticketGraphArea').getContext('2d');
    
        const barGraph3 = new Chart(ctx3, {
            type: 'polarArea',
            data: chartdata,
            options: option
        });
    }

        const url = './app/controls/GraphController.php';


        const getData = () => {
            let dataFetch = fetch(url,
            {
                method: 'GET',
                headers: {"Content-type": "application/json;charset=UTF-8"}
            })  
            .then(response => response.json())
            .then(data => {
                arraySet(data);
            })
            .catch(err => {
                return err
            });
            return dataFetch
        }

        getData(); //START FETCH API PROCESS

})
    
    </script>
</html>


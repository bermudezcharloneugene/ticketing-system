$(document).ready(function (){
    let open = [];
    let closed = [];
    let progress = [];
    let labels = ['Open','In Progress', 'Closed'];
    let type1 = [];
    let type2 = [];
    let type3 = [];
    let type4 = [];
    let env1 = [];
    let env2 = [];
    let env3 = [];


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
            if(arr[i].TYPE_NAME === "ACRF")
            {
                type2.push("data" + i);
            }
            if(arr[i].TYPE_NAME === "REQUEST")
            {
                type3.push("data" + i);
            }
            if(arr[i].TYPE_NAME === "MAINTENANCE")
            {
                type4.push("data" + i);
            }
            if(arr[i].TICKET_ENVIRONMENT_NAME === "UAT")
            {
                env1.push("data" + i);
            }
            if(arr[i].TICKET_ENVIRONMENT_NAME === "PRODUCTION")
            {
                env2.push("data" + i);
            }
            if(arr[i].TICKET_ENVIRONMENT_NAME === "DEVELOPMENT")
            {
                env3.push("data" + i);
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
            labels: ['INCIDENTS', 'ACRF', 'REQUESTS', 'MAINTENANCE'],
            datasets : [
                {
                  label: ['TICKET TYPES'],
                  data: [type1.length, type2.length, type3.length, type4.length],
                },
            
            ],
        };

        const polarAreaData = {
            labels: ['UAT', 'PRODUCTION', 'DEVELOPMENT'],
            datasets : [
                {
                  label: ['ENVIRONMENT'],
                  backgroundColor: [
                    'rgb(34,139,34)',
                    'rgba(173, 216, 230)',
                    // 'rgba(255, 99, 132, 0.2)',
                  ],
                  borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(173, 216, 230)',
                    // 'rgba(255,99,132,1)',
                  ],
                  data: [env1.length, env2.length, env3.length],
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
            data: polarAreaData,
            options: option
        });
    }

        const url = '../../app/controls/GraphController.php';


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
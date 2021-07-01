<?php require_once '../layouts/protected/header.php'; ?>

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

<?php include_once '../layouts/protected/scripts.php'; ?>
<script src="../../node_modules/chart.js/dist/Chart.min.js"></script>
<script src="../../public/js/graph.js?ver=2"> </script>
<?php include_once '../layouts/protected/footer.php'; ?>
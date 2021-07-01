<?php 
    // require_once "../../vendor/autoload.php";
    // use app\classes\AuthChecker;
    // use app\classes\Tickets;
    // use app\classes\Profiles;
    
    // $auth = new AuthChecker;
    // $profiles = new Profiles;

    
?>


<?php require_once '../layouts/protected/header.php'; ?>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-4 mb-5">
                <div class="card card-form" data-toggle="modal" data-target="#post">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-center card-body-wrapper">
                            <i class="ico far fa-plus-square"></i>
                        </div>
                    </div>
                    <div class="card-footer">
                        Post
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4 mb-5">
                <a class=" btn-light" href="./list.php">
                <div class="card card-form" id="listView">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-center card-body-wrapper">
                            <i class="ico fas fa-clipboard-list"></i>
                    
                        </div>
                    </div>
                    <div class="card-footer">
                        List
                    </div>
                </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4 mb-5">
                <div class="card card-form">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-center card-body-wrapper">
                            <i class="ico fas fa-trash"></i>
                        </div>
                    </div>
                    <div class="card-footer">
                        Trash Bin
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4 mb-5">
                <div class="card card-form">
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-center card-body-wrapper">
                            <i class="ico fas fa-file-download"></i>
                        </div>
                    </div>
                    <div class="card-footer">
                        Report
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4 mb-5">
                <a class=" btn-light" href="./dashboard.php" style="text-decoration: none;">
                    <div class="card card-form">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-center card-body-wrapper">
                                <i class="ico fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="card-footer">
                            Graphs
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal for posting new ticket -->
    <div class="modal fade" id="post" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Post Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="errorBox" role="alert">
                        
                    </div>
                    <form action="">
                        <div class="form-group">
                            <input placeholder="Ticket Name" type="text" class="form-control" name="ticket_name" id="ticket_name">
                            
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Ticket Description" name="ticket_description" id="ticket_description" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Root Cause" name="root_cause" id="root_cause" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Solution" name="solution" id="solution" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Remarks" name="remarks" id="remarks" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" id="postTicket" class="btn btn-primary btn-block">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include '../layouts/protected/scripts.php'; ?>

    <script type="text/javascript" src="../../public/js/post.js?ver=5"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#listView').on('click', function(){
                var url = "localhost/ticketing_system2/views/protected/list.php";
                $(this).attr('location',url);
            })
        });
    </script>
<?php include '../layouts/protected/footer.php'; ?>
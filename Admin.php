<?php
include('dbconfig.php');
//SELECT checkin,checkout FROM users WHERE request_status=1
$query = "SELECT * FROM users WHERE request_status = 0";
//echo $query;
$statement = $dbconn->prepare($query);

$statement->execute();

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Auro Moon Residency || Requests</title>
    <link rel="shortcut icon" href="./assect/logo/auro_moon_logo.png" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- css path -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="pb-3" style="min-height:100vh ;">
        <?php include('navbar.php') ?>
        <div class="text-end p-3">
            <a href="./ContactSubmissions.php" class="text-decoration-none me-3">
                <i class="fa fa-envelope"></i> Contact Submissions
            </a>
            <a href="./Booked.php" class="text-decoration-none">
                Booked list <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <h3 class="fw-bold h3 text-center p-3">Request List</h3>
        <div class="container">
            <?php
            if ($statement->rowCount() > 0) {
                $result = $statement->fetchAll();
                //echo '<pre>';
                //print_r($result);
                foreach ($result as $row) {
            ?>
                    <div class="row align-items-center mt-3 shadow-sm p-3 mx-0 border rounded-3" style="background-color: #f1f5f9;" id='row<?php echo $row['id']; ?>'>
                        <div class="col-12 col-md-5 mb-2 mb-md-0" style="color:darkslategray;">
                            <div class="fs-5 fw-bold text-dark"><span><?php echo htmlspecialchars($row['name']); ?></span></div>
                            <div class="fw-semibold text-secondary small"><i class="fa fa-phone me-1"></i><?php echo htmlspecialchars($row['mobnumber']); ?></div>
                            <div class="fw-semibold text-secondary small"><i class="fa fa-id-card me-1"></i><?php echo htmlspecialchars($row['aadhrno']); ?></div>
                            <?php if (!empty($row['aadhaar_pdf'])): ?>
                                <a href="<?php echo htmlspecialchars($row['aadhaar_pdf']); ?>" target="_blank" class="d-inline-flex align-items-center gap-1 mt-1 text-decoration-none badge bg-white text-danger border">
                                    <i class="fa fa-file-pdf-o text-danger"></i> View ID PDF
                                </a>
                            <?php else: ?>
                                <span class="badge bg-light text-muted border mt-1">No PDF</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                            <div class="fw-bold" style="color: #16a085; font-size: 0.95rem;"><i class="fa fa-calendar-check-o me-1"></i>In: <span><?php echo date('d-m-Y', strtotime($row['checkin'])); ?></span></div>
                            <div class="fw-bold" style="color: #138776; font-size: 0.95rem;"><i class="fa fa-calendar-times-o me-1"></i>Out: <span><?php echo date('d-m-Y', strtotime($row['checkout'])); ?></span></div>
                        </div>
                        <div class="col-12 col-md-3 text-md-end text-center pt-2 pt-md-0">
                            <div class="d-inline-flex gap-2">
                                <button type="button" class="accept btn btn-sm btn-success px-3 py-2 shadow-none fw-bold" id='<?php echo $row['id']; ?>'><i class="fa fa-check me-1"></i>Accept</button>
                                <button type="button" class="reject btn btn-sm btn-danger px-3 py-2 shadow-none fw-bold" id='<?php echo $row['id']; ?>'><i class="fa fa-times me-1"></i>Reject</button>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else { ?>
                <div class="row align-items-center mt-3 shadow-lg p-2 mx-2" style="background-color: white; border-radius:10px">
                    <div class="" style="align-self: center;">
                        <div class=" fs-4 fw-bold text-center">No Data found</span></div>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </div>
    <?php include('Footer.php') ?>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.accept').each(function() {
            $(this).click(function() {
                var acceptId = $(this).attr('id');
                console.log(acceptId);
                var action = 'request_accecpt';
                $.ajax({
                    url: 'fetch.php',
                    type: "POST",
                    data: {
                        id: acceptId,
                        action: action
                    },
                    success: function(resp) {
                        console.log(resp);
                        if (resp == 'success') {
                            $("#row" + acceptId).remove();
                            alert('Request Accepted Successfully...!');
                        } else {
                            alert('Somthing Went to Wrong...!');
                        }
                    }
                })
            });
        });

        $('.reject').each(function() {
            $(this).click(function() {
                var rejectId = $(this).attr('id');
                //console.log(acceptId);
                var action = 'request_rejected';
                if (confirm('Are you sure you want to reject this Request...?!')) {
                    $.ajax({
                        url: 'fetch.php',
                        type: "POST",
                        data: {
                            id: rejectId,
                            action: action
                        },
                        success: function(resp) {
                            //console.log(resp);
                            if (resp) {
                                $("#row" + rejectId).remove();
                                alert('Request Rejected Successfully...!');
                            }
                        }
                    })
                }

            });
        });
    });
</script>
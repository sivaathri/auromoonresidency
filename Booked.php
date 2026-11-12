<?php
include('dbconfig.php');
//SELECT checkin,checkout FROM users WHERE request_status=1
$query = "SELECT * FROM users WHERE request_status = 1";
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
    <title>Auro Moon Residency || Booked</title>
    <link rel="shortcut icon" href="./assect/logo/auro_moon_logo.png" type="image/png">
    <!-- boostrao cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- font awesom cdn -->
    <script src="https://kit.fontawesome.com/398c77c1ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- css path -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="pb-3" style="min-height:100vh ;">
        <?php include('navbar.php') ?>
        <div class="text-start p-3"><a href="./Admin.php" class="text-decoration-none"><i class="fa-solid fa-arrow-left"></i> Request list</a></div>
        <h3 class="fw-bold h3 text-center p-3">Already Booked</h3>
        <div class="container">
            <?php
            if ($statement->rowCount() > 0) {
                foreach ($statement as $rows) {
            ?>
                    <div class="row align-items-center mt-3 shadow-sm p-3 mx-0 border rounded-3 bg-white" id="row<?php echo $rows['id']; ?>">
                        <div class="col-12 col-sm-3 col-md-2 text-center mb-2 mb-sm-0">
                            <img src="assect/images/reserve.png" alt="Reserved" style="width: 70px; max-width: 100%;" class="img-fluid">
                        </div>
                        <div class="col-12 col-sm-9 col-md-4 mb-2 mb-md-0">
                            <div class="fs-5 fw-bold text-dark"><span><?php echo htmlspecialchars($rows['name']); ?></span></div>
                            <div class="fw-semibold text-secondary small"><i class="fa fa-phone me-1"></i><?php echo htmlspecialchars($rows['mobnumber']); ?></div>
                            <div class="fw-semibold text-secondary small"><i class="fa fa-id-card me-1"></i><?php echo htmlspecialchars($rows['aadhrno']); ?></div>
                        </div>
                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                            <div class="fw-bold" style="color: #16a085; font-size: 0.95rem;"><i class="fa fa-calendar-check-o me-1"></i>In: <span><?php echo date('d-m-Y', strtotime($rows['checkin'])); ?></span></div>
                            <div class="fw-bold" style="color: #138776; font-size: 0.95rem;"><i class="fa fa-calendar-times-o me-1"></i>Out: <span><?php echo date('d-m-Y', strtotime($rows['checkout'])); ?></span></div>
                        </div>
                        <div class="col-12 col-md-2 text-md-end text-center pt-2 pt-md-0">
                            <button type="button" class="cancel btn btn-sm btn-outline-danger shadow-none fw-bold px-3 py-2" id='<?php echo $rows['id']; ?>'><i class="fa fa-ban me-1"></i>Cancel</button>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="row align-items-center mt-3 shadow-lg p-2 mx-2" style="background-color: white; border-radius:10px">
                    <div class="" style="align-self: center;">
                        <div class=" fs-4 fw-bold text-center">No Data found</span></div>
                    </div>
                </div>
            <?php  }
            ?>
        </div>
    </div>
    <?php include('Footer.php') ?>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.cancel').each(function() {
            $(this).click(function() {
                //console.log('i am clicked');
                var cid = $(this).attr('id');
                //console.log(cid);
                var action = 'cancel_booking';
                $.ajax({
                    url: 'fetch.php',
                    type: 'POST',
                    data: {
                        id: cid,
                        action: action
                    },
                    success: function(resp) {
                        console.log(resp);
                        if (resp == 'success') {
                            $('#row' + cid).remove();
                            //$("#row" + rejectId).remove();
                            alert('elbooking canced...!');
                        }
                    }
                });

            });
        });
    });
</script>
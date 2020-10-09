<?php 

    error_reporting(0);

    $con = mysqli_connect('localhost', 'root', '', 'multi_delete');

    if (isset($_POST['add'])) {
        $fullname = $_POST['fullname'];
        $education = $_POST['education'];
        $date = $_POST['date'];

        $sql = "INSERT INTO tblusers(fullname, education, postingDate) VALUES('$fullname','$education', '$date')";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo "<script>alert('Inserted data successfully!');</script>";
        } else {
            echo "<script>alert('Something went wrong');</script>";
        }
    }

    if (isset($_POST['delete'])) {
        if (count($_POST['ids']) > 0) {
            // Imploding checkbox ids
            $all = implode(",", $_POST['ids']);
            $sql = mysqli_query($con, "DELETE FROM tblusers WHERE id in ($all)");
            if ($sql) {
                $success = "Data has been deleted successfully";
            } else {
                $errmsg = "Error while deleting. Please try again.";
            }
        } else {
            $errmsg = "You need to select atleast one checkbox to delete!";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
</head>
<body>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add data</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST">
            <div class="modal-body">
                    <label for="name" class="form-label mt-3">Add Fullname</label>
                    <input type="text" class="form-control" name="fullname" placeholder="Add fullname">
                    <label for="education" class="form-label mt-3">Add Education</label>
                    <input type="text" class="form-control" name="education" placeholder="Add education">
                    <label for="date" class="form-label mt-3">Add Date</label>
                    <input type="date" class="form-control" name="date" placeholder="Add date">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="add" class="btn btn-primary">Add</button>
            </div>
        </form>
        </div>
    </div>
    </div>


    <div class="container">
        <form method="POST">
        <?php if(isset($errmsg)) { ?>
        <div class='alert alert-danger' role='alert'><?php echo $errmsg; ?></div>
        <?php } ?>
        <table class="table table-striped">
        <!-- Delete Button -->
        <tr>
            <td colspan="4">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
            Add
            </button>
            <input type="submit" name="delete" value="Delete" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete?');"></td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" class="form-check-input" id="select_all">
                <label class="form-check-label">Select all</label>    
            </td>
            <td>Name</td>
            <td>Education</td>
            <td>Date</td>
        </tr>
            <?php
                $query=mysqli_query($con,"SELECT * FROM tblusers");
                $totalcnt = mysqli_num_rows($query);
                if ($totalcnt > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><input type="checkbox" class="checkbox" name="ids[]" value="<?php echo htmlentities($row['id']);?>"/></td>
                    <td><?php echo htmlentities($row['fullname']);?></td>
                    <td><?php echo htmlentities($row['education']);?></td>
                    <td><?php echo htmlentities($row['postingDate']);?></td>
                </tr>
                <?php } } else { ?>
                <tr>
                    <td  colspan="4">No Record Found</td>
                </tr>
            <?php } ?>
        </table>
        </form>
    </div>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#select_all').on('click',function(){
                if(this.checked) {
                    $('.checkbox').each(function(){
                        this.checked = true;
                    });
                } else {
                    $('.checkbox').each(function(){
                        this.checked = false;
                    });
                }
            });
            $('.checkbox').on('click',function(){
                if($('.checkbox:checked').length == $('.checkbox').length){
                    $('#select_all').prop('checked',true);
                } else {
                    $('#select_all').prop('checked',false);
                }
            });
    });
    </script>
</body>
</html>
<?php
/*
 * PHP CRUD Template v1.0
 * Developed by Naveen Dharmathunga
 * GitHub: https://github.com/D-Naveenz/hospital-crud-project
 */
require_once "../core/config.php";

// Connect to the database
$database = createMySQLConn();
$res_select = $database->query("SELECT * FROM `supplies`");

// Delete Request
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = unserialize($_GET['delete']);
    generateInfoMsg($database, $database->query("DELETE FROM supplies WHERE Drug_Code = '$id[0]' 
                       AND Reg_No = '$id[1]' AND Supplied_Date = '$id[2]'"),"supply", $id, "deleted");

    // reload the page
    header("Location: ".$_SERVER["PHP_SELF"]."?message");
}

// Post requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['btnAdd'])) {
        // Create request
        $sql = "INSERT INTO supplies (Drug_Code, Reg_No, Supplied_Date, Drug_Type, Unit_Cost, Quantity, Total_Cost) VALUES (?,?,?,?,?,?,?)";
        $sql_statement = $database->prepare($sql);
        // bind param with references : https://www.php.net/manual/en/language.references.whatare.php
        $sql_statement->bind_param("ssssiii", $Val1, $Val2, $Val3, $Val4, $Val5, $Val6, $Val7);
        $Val1 = $_POST['Val1'];
        $Val2 = $_POST['Val2'];
        $Val3 = $_POST['Val3'];
        $Val4 = $_POST['Val4'];
        $Val5 = $_POST['Val5'];
        $Val6 = $_POST['Val6'];
        $Val7 = $_POST['Val7'];
        // Execution
        generateInfoMsg($sql_statement, $sql_statement->execute(),"supply", $_POST['Val1'], "added");
        $sql_statement->close();

        // reload the page
        header("Location: ".$_SERVER["PHP_SELF"]."?message");
    }

    if (isset($_POST['btnUpdate'])) {
        // Update request
        $sql = "UPDATE supplies SET Drug_Type = ?, Unit_Cost = ?, Quantity = ?, Total_Cost = ? WHERE supplies.Drug_Code = ? AND supplies.Reg_No = ? AND supplies.Supplied_Date = ?;";
        $sql_statement = $database->prepare($sql);
        // bind param with references : https://www.php.net/manual/en/language.references.whatare.php
        $sql_statement->bind_param("siiisss", $Val4, $Val5, $Val6, $Val7, $Val1, $Val2, $Val3);
        $Val1 = $_POST['Val1'];
        $Val2 = $_POST['Val2'];
        $Val3 = $_POST['Val3'];
        $Val4 = $_POST['Val4'];
        $Val5 = $_POST['Val5'];
        $Val6 = $_POST['Val6'];
        $Val7 = $_POST['Val7'];
        // Execution
        generateInfoMsg($sql_statement, $sql_statement->execute(),"supply", $_POST['Val1'], "updated");
        $sql_statement->close();

        // reload the page
        header("Location: ".$_SERVER["PHP_SELF"]."?message");
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous">
    </script>

    <!-- Crud page Script -->
    <script type="text/javascript" src="../js/crud_page.js"></script>

    <title>Supplies</title>
</head>
<body>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </symbol>
</svg>

<?php if (isset($_SESSION['res_msg']) && isset($_GET['message'])): ?>
    <!-- Display Alert -->
    <div class="alert alert-<?=$_SESSION['res_msg_type']?> alert-dismissible d-flex align-items-center fade show mb-0" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="<?php
            echo match ($_SESSION['res_msg_type']) {
                "success" => '#check-circle-fill',
                "danger" => '#exclamation-triangle-fill',
                default => '#info-fill',
            }; ?>"/></svg>
        <div>
            <?php
            echo $_SESSION['res_msg'];
            unset($_SESSION['res_msg']);
            ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <!-- Display Alert -->
<?php endif; ?>

<!-- Body Header -->
<div class="container-fluid p-5 bg-primary text-white text-center">
    <h1>List of Supplies</h1>
    <p>Suwa Sahana Hospital</p>
</div>
<!-- Body Header -->

<div class="container-fluid" style="margin-top: 20px;" id="nav-bed">
    <div class="container">
        <div class="row justify-content-center">
            <table class="table table-hover">
                <col style="width: 12%;" />
                <col style="width: 12%;" />
                <col style="width: 12%;" />
                <col style="width: 12%;" />
                <col style="width: 12%;" />
                <col style="width: 12%;" />
                <col style="width: 12%;" />
                <col style="width: 16%;" />
                <thead style="background-color: blue; color: white">
                <tr>
                    <th scope="col">Drug Code</th>
                    <th scope="col">Register No</th>
                    <th scope="col">Supplied Date</th>
                    <th scope="col">Drug Type</th>
                    <th scope="col">Unit Cost</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total Cost</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <?php
                $row_count = 0;
                while ($row = $res_select->fetch_assoc()): ?>
                    <tr id="row-<?=$row_count?>">
                        <td><?=$row['Drug_Code']?></td>
                        <td><?=$row['Reg_No']?></td>
                        <td><?=$row['Supplied_Date']?></td>
                        <td><?=$row['Drug_Type']?></td>
                        <td><?=$row['Unit_Cost']?></td>
                        <td><?=$row['Quantity']?></td>
                        <td><?=$row['Total_Cost']?></td>
                        <td>
                            <a href="#row-edit-<?=$row_count?>" class="btn btn-info data-row-toggle">Edit</a>
                            <!-- Array format a:3:{i:0;s:5:"val1";i:1;s:5:"val2";i:2;s:10:"val3";} -->
                            <a href='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete=a:3:{i:0;s:5:"<?=$row['Drug_Code']?>";i:1;s:5:"<?=$row['Reg_No']?>";i:2;s:10:"<?=$row['Supplied_Date']?>";}'
                               class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <tr id="row-edit-<?=$row_count?>" class="update-row">
                            <td>
                                <?=$row['Drug_Code']?>
                                <label>
                                    <input type="hidden" class="form-control" name="Val1" value="<?=$row['Drug_Code']?>">
                                </label>
                            </td>
                            <td>
                                <?=$row['Reg_No']?>
                                <label>
                                    <input type="hidden" class="form-control" name="Val2" value="<?=$row['Reg_No']?>">
                                </label>
                            </td>
                            <td>
                                <?=$row['Supplied_Date']?>
                                <label>
                                    <input type="hidden" class="form-control" name="Val3" value="<?=$row['Supplied_Date']?>">
                                </label>
                            </td>
                            <td>
                                <label>
                                    <input type="text" class="form-control" name="Val4" value="<?=$row['Drug_Type']?>">
                                </label>
                            </td>
                            <td>
                                <label>
                                    <input type="text" class="form-control" name="Val5" value="<?=$row['Unit_Cost']?>">
                                </label>
                            </td>
                            <td>
                                <label>
                                    <input type="text" class="form-control" name="Val6" value="<?=$row['Quantity']?>">
                                </label>
                            </td>
                            <td>
                                <label>
                                    <input type="text" class="form-control" name="Val7" value="<?=$row['Total_Cost']?>">
                                </label>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success" name="btnUpdate">Done</button>
                                <a href="#row-<?=$row_count++?>" class="btn btn-danger update-row-toggle">Close</a>
                            </td>
                        </tr>
                    </form>
                <?php endwhile; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <tr id="row-add" class="add-row table-info">
                        <td>
                            <label>
                                <input type="text" class="form-control" name="Val1"">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="text" class="form-control" name="Val2"">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="date" class="form-control" name="Val3">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="text" class="form-control" name="Val4">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="text" class="form-control" name="Val5">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="text" class="form-control" name="Val6">
                            </label>
                        </td>
                        <td>
                            <label>
                                <input type="text" class="form-control" name="Val7">
                            </label>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success" name="btnAdd">Done</button>
                            <button type="reset" class="btn btn-danger add-row-toggle" name="btnCancel">Cancel</button>
                        </td>
                    </tr>
                </form>
            </table>
        </div>
    </div>
    <div class="container">
        <a href="#row-add" class="btn btn-info btn-block" id="btn-add">Add</a>
        <a href="<?php echo $_SESSION['previous_page']; ?>" class="btn btn-secondary btn-block">Close</a>
    </div>
</div>
</body>
</html>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Get variables
$patient = $_GET["patient"];
$userid = $_SESSION['userid'];

// Connect to DB
include ("../../dbconnect.php");

//SQL query for therapy table
$therapy = mysqli_query($conn, 
"SELECT therapy.therapyID, therapy_list.name AS therapy, medicine.name, therapy_list.Dosage
FROM therapy
INNER JOIN therapy_list ON therapy.TherapyList_IDtherapylist = therapy_list.therapy_listID
INNER JOIN medicine ON therapy_list.Medicine_IDmedicine = medicine.medicineID
WHERE therapy.User_IDmed = '$userid' AND therapy.User_IDpatient = '$patient'");

//SQL query for test session table
$testsession = mysqli_query($conn, 
"SELECT test_session.test_SessionID, test_session.DataURL, test.testID, test.dateTime, therapy.therapyID
FROM therapy
INNER JOIN test ON therapy.therapyID = test.Therapy_IDtherapy
INNER JOIN test_session ON test.testID = test_session.Test_IDtest 
WHERE therapy.User_IDmed = '$userid' AND therapy.User_IDpatient = '$patient'");
?>

<!-- Build the modal content -->
<div class="modal-content">
    <div class="modal-top">
        <p id="modal-heading">Patient ID: <?php echo $patient ?></p>
        <i class="fas fa-times" id="modal-close"></i>
    </div>
    <div class="modal-therapy-tables">
        <!-- Therapy list/table -->
        <p class="heading">Therapies</p>
        <table class="therapy-list">
            <thead>
                <tr>
                    <th>Therapy ID</th>
                    <th>Therapy</th>
                    <th>Medicine</th>
                    <th>Dosage</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($row = $therapy->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row["therapyID"]?></td>
                    <td><?php echo $row["therapy"]?></td>
                    <td><?php echo $row["name"]?></td>
                    <td><?php echo $row["Dosage"]?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>

        <!-- Test session list/table -->
        <p class="heading">Test sessions</p>
        <table class="test-session-list">
            <thead>
                <tr>
                    <th>Session ID</th>
                    <th>Session Data</th>
                    <th>Test ID</th>
                    <th>Test Date</th>
                    <th>Therapy ID</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($row = $testsession->fetch_assoc()) {
            ?>
                <tr>
                    <td>
                        <?php
                        echo $row["test_SessionID"];
                        $currTestSession = $row["test_SessionID"];
                        ?>
                    </td>
                    <td><?php echo $row["DataURL"]?></td>
                    <td><?php echo $row["testID"]?></td>
                    <td><?php echo $row["dateTime"]?></td>
                    <td><?php echo $row["therapyID"]?></td>
                    <td>
                        <?php
                        // Display any notes for the test session
                        $session_notes = mysqli_query($conn,"SELECT note.note, user.username
                        FROM note
                        INNER JOIN user ON note.User_IDmed = user.userID
                        WHERE note.Test_Session_IDtest_session = '$currTestSession'");
                        
                        if ($session_notes->num_rows > 0) {
                            while($row = $session_notes->fetch_assoc()) {
                                echo $row["username"] . ': ' . $row["note"] . '<br>';
                            }
                        }else{
                            echo "-";
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
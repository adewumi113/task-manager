<?php
    error_reporting(E_ALL);
    session_start();
    require_once "../classes/Task.php";
    require_once "../classes/utilities.php";
    $previousPage = $_SERVER['HTTP_REFERER'];

    if ($_POST && isset($_POST["submitTask"])) {
        $taskName = sanitizer($_POST["taskName"]);
        $taskStartDate = $_POST["startDate"];
        $taskEndDate = $_POST["endDate"];
        $taskSection = $_POST["taskSection"];
        $userid = $_SESSION['user_online'];

        if (!empty($taskName) && !empty($taskStartDate) && !empty($taskEndDate) && !empty($taskSection)) {

            $task = $Task->add_task($taskName, $taskStartDate, $taskEndDate, $taskSection, $taskSection, $userid);

            if ($task) {
                header("Location: $previousPage");
                return true;
            } else {
                header("Location: $previousPage");
                return false;
            }
        } else {
            echo json_encode(["status" => "error", "message" => "All fields are required"]);
            header("Location: $previousPage");
        }
    }
?>

<!-- ======= Header ======= -->
<?php
    require_once "partials/header.php";

?>
<!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php
        require_once "partials/sidebar2.php";
    ?>
    <!-- End Sidebar-->

    <main id="main" class="main maindiv">

      <div class="pagetitle">
        <h1>Tasks</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Workspace</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active">mytasks</li>
          </ol>
        </nav>
          <?php
              require_once "partials/successmessage.php";
          ?>
          <?php
              require_once "partials/errormessage.php";
          ?>
          <p id="feedback"></p>
      </div><!-- End Page Title -->

      <section class="section">
        <div class="row taskrow nowrap"> 
          <div class="col-lg-3 taskcol droppable bg-secondary-subtle" id="backlog" style="width:360px">
            <div class="card-header bg-secondary-subtle pt-2 d-flex justify-content-between sticky-top z-1">
              <div class="d-flex align-items-center">
                <div class="d-flex justify-content-between">
                  <div class="pe-3 col-7" style="width:250px">
                    <h5 class="py-2"><i class="fa-solid fa-plus me-3"></i>Backlog</h5>
                  </div>
                  <div class="pe-0 col-3" style="width:65px">
                    <button type="button" class="btn py-0 px-1 addTaskButton createNewTaskBacklog" data-toggle="popover"  data-bs-content="Add task" data-bs-toggle="modal" data-bs-target="#taskModal">
                      <i class="fa-solid fa-plus" role="button"></i>
                    </button>
                    <button type="button" class="btn py-0 ps-1" data-toggle="popover"  data-bs-content="More options">
                      <i class="fa-solid fa-ellipsis" role="button"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <?php 
                $backlogtask = $Task->fetch_backlogtask($userid, 1);
                $inprogresstask = $Task->fetch_inprogresstask($userid, 2);
                $completedtask = $Task->fetch_completedtask($userid, 3);
              if ($backlogtask) {
                foreach ($backlogtask as $btask) {
                  $btaskID = $btask['task_id'];
                  $backlog_subtasks = $subtask->fetch_subtask($btaskID);
                  // echo($btaskID);
                  // die();
                  if($backlog_subtasks){
                      $btask_subtasks = count($backlog_subtasks);
                  }else{
                    $btask_subtasks = 0;
                  }

                  $backlog_task_attachment = $Task->fetch_task_attachments($btaskID);
                  if($backlog_task_attachment){
                    $btask_attachmentName = $backlog_task_attachment[0]['attachment_name'];
                    $btask_attachmentType = $backlog_task_attachment[0]['attachment_type'];
                    $btaskattachment = $attachment->generatePreview($btask_attachmentName, $btask_attachmentType);
                  }else{
                    $btaskattachment = "";   
                  }
                  
                  $taskenddate = $btask['task_end_date'];
                  $today = $_SESSION['today'];
                  $enddate = new DateTime($taskenddate);
                  $interval = $today->diff($enddate);
                  $daysLeft = $interval->days + 1;
  
                  $str = '<p style="width:150px" value="">'; 
                   // Check if the task is overdue
                   if ($interval->invert == 1) {
                    // Task is overdue
                    $daysLeft = -$interval->days;
                    $str = '<p style="width:150px" value=" ">'; 
                    $str .= '<i class="fa-solid fa-clock mx-2 text-danger"></i>';
                    $str .= "Due";
                    $str .= '</p>';
                  }
                  else if($daysLeft >= 2){
                    $str = '<p style="width:150px" value=" ">'; 
                    $str .= '<i class="fa-solid fa-clock mx-2 text-success"></i>';
                    $str .= $daysLeft . " days left";
                    $str .= '</p>';
                  }else if($daysLeft < 2){
                    $str = '<p style="width:150px" value=" ">'; 
                    $str .= '<i class="fa-solid fa-clock mx-2 text-warning"></i>';
                    $str .= $daysLeft . " day left";
                    $str .= '</p>';
                  }
                $str .= '</p>';
              
            ?>

            <div class="card border-warning mx-3 draggable newtaskcard" draggable="true" style="max-width: 20rem;">
              <div class="card-body d-flex align-items-center m-0 mt-1">
                <p class="btn btn-white text-decoration-none text-black p-0 m-0"><i class="fa fa-check-circle text-secondary" style="font-size:20px;"></i></p>
                <p class="taskname ps-2 mt-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions" data-value="<?php echo $btask["task_id"] ?>"> <?php echo $btask['task_name'] ?></p>
              </div>
              <div>
                <?php  
                  echo $btaskattachment;
                ?>
              </div>
              <div class="d-flex justify-content-between mx-3">
                <!-- <button class="btn border border-white py-0 ps-2 datepicker-btn" type="button"><i class="fas fa-calendar-alt"></i></button> -->
                <?php echo $str;?>
                <div>
                  
                  <i class="fa-regular fa-thumbs-up mx-2"></i>
                  <?php if($btask_subtasks !== 0){?>
                    <i class="fa-solid fa-code-branch fa-rotate-90 mx-2"></i>
                    <span class="border px-2 rounded-pill"><?php echo $btask_subtasks; ?></span>
                  <?php }?>
                    
                </div>
              </div>
            </div>

            <?php } } ?> 

            <div class="card-footer addTaskFooter pt-2 bg-secondary-subtle">
              <a href="" class="text-decoration-none text-secondary text-center addTaskLink createNewTaskBacklog" data-bs-toggle="modal" data-bs-target="#createNewTaskModal" >
                <p class=""><b><i class="fa fa-plus me-2"></i>Add new item</b></p>
              </a>
            </div>
          </div>
          <div class="col-lg-3 taskcol droppable bg-secondary-subtle" id="in_progress" style="width:360px">
            <div class="card-header bg-secondary-subtle pt-2 d-flex justify-content-between sticky-top z-1">
              <div class="d-flex align-items-center">
                <div class="d-flex justify-content-between">
                  <div class="pe-3 col-7" style="width:250px">
                    <h5 class="py-2"><i class="fa-solid fa-plus me-3"></i>In-Progress</h5>
                  </div>
                  <div class="pe-0 col-3" style="width:65px">
                    <button type="button" class="btn py-0 px-1 addTaskButton" data-toggle="popover"  data-bs-content="Add task" data-bs-toggle="modal" data-bs-target="#taskModal" id="createNewTask">
                      <i class="fa-solid fa-plus" role="button"></i>
                    </button>
                    <button type="button" class="btn py-0 ps-1" data-toggle="popover"  data-bs-content="More options">
                      <i class="fa-solid fa-ellipsis" role="button"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <?php 
              if($inprogresstask){
                foreach($inprogresstask as $itask){
                  $itaskID = $itask['task_id'];
                  $inprogress_subtasks = $subtask->fetch_subtask($itaskID);
                  if($inprogress_subtasks){
                      $itask_subtasks = count($inprogress_subtasks);
                  }else{
                    $itask_subtasks = 0;
                  }

                  $inprogress_task_attachment = $Task->fetch_task_attachments($itaskID);
                  if($inprogress_task_attachment){
                    $itask_attachmentName = $inprogress_task_attachment[0]['attachment_name'];
                    $itask_attachmentType = $inprogress_task_attachment[0]['attachment_type'];
                    $itaskattachment = $attachment->generatePreview($itask_attachmentName, $itask_attachmentType);
                  }else{
                    $itaskattachment = "";   
                  }

                  $taskenddate = $itask['task_end_date'];
                  $today = $_SESSION['today'];
                  $enddate = new DateTime($taskenddate);
                  $interval = $today->diff($enddate);
                  $daysLeft = $interval->days + 1;
                  $str = '<p style="width:150px" value="">'; 
                  // Check if the task is overdue
                  if ($interval->invert == 1) {
                    // Task is overdue
                    $daysLeft = -$interval->days;
                    $str = '<p style="width:150px" value=" ">'; 
                    $str .= '<i class="fa-solid fa-clock mx-2 text-danger"></i>';
                    $str .= "Due";
                    $str .= '</p>';
                  }
                  else if($daysLeft >= 2){
                    $str = '<p style="width:150px" value=" ">'; 
                    $str .= '<i class="fa-solid fa-clock mx-2 text-success"></i>';
                    $str .= $daysLeft . " days left";
                    $str .= '</p>';
                  }else if($daysLeft < 2){
                    $str = '<p style="width:150px" value=" ">'; 
                    $str .= '<i class="fa-solid fa-clock mx-2 text-warning"></i>';
                    $str .= $daysLeft . " day left";
                    $str .= '</p>';
                  }
                  $str .= '</p>';
            ?>

            <div class="card border-warning mx-3 draggable newtaskcard" draggable="true" style="max-width: 20rem;">
              <div class="card-body d-flex align-items-center m-0 mt-1">
                <p class="btn btn-white text-decoration-none text-black p-0 m-0"><i class="fa fa-check-circle text-warning" style="font-size:20px;"></i></p>
                <p class="taskname ps-2 mt-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions" data-value="<?php echo $itask["task_id"] ?>"> <?php echo $itask['task_name'] ?></p>
              </div>

              <div>
                <?php  
                  echo $itaskattachment;
                ?>
              </div>

              <div class="d-flex justify-content-between mx-3">
                <!-- <button class="btn border border-white py-0 ps-2 datepicker-btn" type="button"><i class="fas fa-calendar-alt"></i></button> -->
                <?php echo $str;?>
                <div>
                  <i class="fa-regular fa-thumbs-up mx-2"></i>
                  <?php if($itask_subtasks !== 0){?>
                    <i class="fa-solid fa-code-branch fa-rotate-90 mx-2"></i>
                    <span class="border px-2 rounded-pill"><?php echo $itask_subtasks; ?></span>
                  <?php }?>
                </div>
              </div>
            </div>

            <?php } }?> 

            <div class="card-footer addTaskFooter pt-2 bg-secondary-subtle">
              <a href="" class="text-decoration-none text-secondary text-center addTaskLink" data-bs-toggle="modal" data-bs-target="#createNewTaskModal" id="createNewTask">
                <p class=""><b><i class="fa fa-plus me-2"></i>Add new item</b></p>
              </a>
            </div>
          </div>
          <div class="col-lg-3 taskcol droppable bg-secondary-subtle" id="completed" style="width:360px" >
            <div class="card-header bg-secondary-subtle pt-2 d-flex justify-content-between sticky-top z-1">
              <div class="d-flex align-items-center">
                <div class="d-flex justify-content-between">
                  <div class="pe-3 col-7" style="width:250px">
                    <h5 class="py-2"><i class="fa-solid fa-plus me-3"></i>Completed</h5>
                  </div>
                  <div class="pe-0 col-3" style="width:65px">
                    <button type="button" class="btn py-0 px-1 addTaskButton" data-toggle="popover"  data-bs-content="Add task" data-bs-toggle="modal" data-bs-target="#taskModal" id="createNewTask">
                      <i class="fa-solid fa-plus" role="button"></i>
                    </button>
                    <button type="button" class="btn py-0 ps-1" data-toggle="popover"  data-bs-content="More options">
                      <i class="fa-solid fa-ellipsis" role="button"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <?php 
              if($completedtask){
                foreach($completedtask as $ctask){
                  $ctaskID = $ctask['task_id'];
                  $completed_subtasks = $subtask->fetch_subtask($ctaskID);
                  // echo($btaskID);
                  // die();
                  if($completed_subtasks){
                      $ctask_subtasks = count($completed_subtasks);
                  }else{
                    $ctask_subtasks = 0;
                  }

                  $completed_task_attachment = $Task->fetch_task_attachments($ctaskID);
                  if($completed_task_attachment){
                    $ctask_attachmentName = $completed_task_attachment[0]['attachment_name'];
                    $ctask_attachmentType = $completed_task_attachment[0]['attachment_type'];
                    $ctaskattachment = $attachment->generatePreview($ctask_attachmentName, $ctask_attachmentType);
                  }else{
                    $ctaskattachment = "";   
                  }

                  $taskenddate = $ctask['task_end_date'];
                  $today = new DateTime();
                  $enddate = new DateTime($taskenddate);
                  $interval = $today->diff($enddate);
                  $daysLeft = $interval->days + 1;
                  if($daysLeft >= 2){
                    $str = '<p style="width:150px" value=" ">'; 
                    $str .= '<i class="fa-solid fa-clock mx-2 text-success"></i>';
                    $str .= $daysLeft . " days left";
                    $str .= '</p>';
                  }
         
      
            ?>

            <div class="card border-warning draggable mx-3 newtaskcard" style="max-width: 20rem;" draggable="true">
              <div class="card-body d-flex align-items-center m-0 mt-1">
                <p class="btn btn-white text-decoration-none text-black p-0 m-0"><i class="fa fa-check-circle text-success" style="font-size:20px;"></i></p>
                <p class="taskname ps-2 mt-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions" data-value="<?php echo $ctask["task_id"] ?>"> <?php echo $ctask['task_name']; ?></p>
              </div>

              <div>
                <?php  
                  echo $ctaskattachment;
                ?>
              </div>

              <div class="d-flex justify-content-between mx-3">

                  <p style="width:150px" value=" " class="text-success">
                    <i class="fa-solid fa-clock mx-2 text-success"></i>
                    <strong>Completed</strong>
                  </p>
                <div>
                  <i class="fa-regular fa-thumbs-up mx-2"></i>
                  <?php if($ctask_subtasks !== 0){?>
                    <i class="fa-solid fa-code-branch fa-rotate-90 mx-2"></i>
                    <span class="border px-2 rounded-pill"><?php echo $ctask_subtasks; ?></span>
                  <?php }?>
                </div>
              </div>
            </div>

            <?php } }?> 

            <div class="card-footer addTaskFooter pt-2 bg-secondary-subtle">
              <a href="" class="text-decoration-none text-secondary text-center addTaskLink" data-bs-toggle="modal" data-bs-target="#createNewTaskModal" id="createNewTask">
                <p class=""><b><i class="fa fa-plus me-2"></i>Add new item</b></p>
              </a>
            </div>
          </div>
          <div class="col-lg-3 taskcol droppable bg-secondary-subtle d-none new-section-box" style="width:360px">
            <div class="card-header bg-secondary-subtle pt-2 d-flex justify-content-between sticky-top z-1">
              <div class="d-flex align-items-center">
                <div class="d-flex justify-content-between">
                  <div class="pe-3 col-7" style="width:250px">
                    <h5 class="py-2"><i class="fa-solid fa-plus me-3"></i>Add section</h5>
                  </div>
                  <div class="pe-0 col-3" style="width:65px">
                    <button type="button" class="btn py-0 px-1 addTaskButton" data-toggle="popover"  data-bs-content="Add task" data-bs-toggle="modal" data-bs-target="#taskModal" id="createNewTask">
                      <i class="fa-solid fa-plus" role="button"></i>
                    </button>
                    <button type="button" class="btn py-0 ps-1" data-toggle="popover"  data-bs-content="More options">
                      <i class="fa-solid fa-ellipsis" role="button"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer addTaskFooter pt-2 bg-secondary-subtle">
              <a href="" class="text-decoration-none text-secondary text-center addTaskLink" data-bs-toggle="modal" data-bs-target="#createNewTaskModal" id="createNewTask">
                <p class=""><b><i class="fa fa-plus me-2"></i>Add new item</b></p>
              </a>
            </div>
          </div>
        

          <div class="col-lg-3 taskcol bg-secondary-subtle add-new-section" style="width:360px">
            <div class="card-header bg-secondary-subtle pt-2 d-flex justify-content-between sticky-top z-1">
              <div class="d-flex align-items-center">
                <div class="d-flex justify-content-between">
                  <div class="pe-3 col-7" style="width:250px">
                    <h5 class="py-2"><i class="fa-solid fa-plus me-3"></i>Add section</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
        
      </section>
      <!--Create task modal-->
      <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="taskModalLabel">Add a new task</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">  
              <form method="POST" action="process/process_task.php" id="addTask">
                <div class="mb-3">
                  <input type="text" class="form-control" name="taskName" id="taskName" placeholder="Input task name">
                </div>
                <div class="mb-3">
                  <label for="startDate">Task start date</label>
                  <input type="date" class="form-control" name="startDate" id="startDate">
                </div>
                <div class="mb-3">
                  <label for="endDate">Task end date</label>
                  <input type="date" class="form-control" name="endDate" id="endDate">
                </div>
                <div class="mb-3">
                  <select name="taskSection" class="form-control mb-2">
                    <option value="">Select task section</option>
                    <?php foreach($sections as $section){ ?>
                      <option value="<?php echo $section["task_section_id"]?>"> <?php echo $section["task_section_name"]?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="modal-footer">
                  <button type="submit" name="submitTask" value="Add Task" id="submitTask" class="btn btn-primary">Add Task</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Task Details Off-canvas ---->
      <div class="offcanvas offcanvas-end w-50" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header bg-primary">
            <h5 class="offcanvas-title text-white" id="offcanvasWithBothOptionsLabel">Task Details</h5>
            <button type="button" id="closeBtn" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <p class="nfeedback"></p>
        <div class="offcanvas-body">
            
        </div>
        <div class="offcanvas-footer">
          <div class="card">
            <div class="card-header">
              <h5>Comment</h5>
            </div>
            <div class="card-body">
              <form>
                <textarea class="form-control mb-2" rows="2" id="commentText" placeholder="Add comment"></textarea>
                <submit class="btn btn-primary" type="button" name="commentBtn" id="commentBtn" value="Add comment">Comment</submit>
              </form>
            </div>
          </div>
        </div> 
    </div> 

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php
        require_once "partials/footer.php";
    ?>
    <!-- End Footer -->
    <script>
        $(document).ready(function(){

          $('.add-section').click(function() {
            var $clickedHeader = $(this);
            var $newTaskBucket = $clickedHeader.closest('.newtaskbucket');
            
            $clickedHeader.addClass('d-none');
            $newTaskBucket.find('.section-name-container').removeClass('d-none');
            $newTaskBucket.find('.section-name-input').focus();
          });

          $('.section-name-input').on('input', function() {
            var sectionName = $(this).val();
            var $sectionNameContainer = $(this).closest('.section-name-container');
            var $sectionHeader = $sectionNameContainer.find('.add-section');
            var $sectionNameDisplay = $sectionNameContainer.find('.sectionname');

            if (sectionName.trim() === '') {
              $sectionHeader.removeClass('d-none');
              $sectionNameContainer.addClass('d-none');
            } else {
              $sectionNameDisplay.text(sectionName);
              $sectionNameContainer.removeClass('d-none');
              $sectionNameDisplay.removeClass('d-none');
              
              
              // Create a new task bucket
              var $taskRow = $sectionNameContainer.closest('.taskrow');
              var $newTaskBucketClone = $taskRow.find('.newtaskbucket').first().clone(true);
              $newTaskBucketClone.find('.section-name-container').addClass('d-none');
              $newTaskBucketClone.find('.section-name-input').val('');
              $taskRow.append($newTaskBucketClone);
            }
          });

          $('.sectionname').click(function() {
            var $sectionName = $(this);
            var $sectionNameContainer = $sectionName.closest('.section-name-container');
            
            $sectionName.addClass('d-none');
            $sectionNameContainer.find('.section-name-input').removeClass('d-none').focus();
          });

          // Handle input focus out for section name edit
          $('.section-name-input').focusout(function() {
            var sectionName = $(this).val();
            var $sectionNameContainer = $(this).closest('.section-name-container');
            var $sectionNameDisplay = $sectionNameContainer.find('.sectionname');
            
            if (sectionName.trim() !== '') {
              $sectionNameDisplay.text(sectionName);
              $sectionNameDisplay.removeClass('d-none');
            } else {
              $sectionNameDisplay.addClass('d-none');
              $sectionNameContainer.addClass('d-none');
            }
            
            $(this).val('');
            $(this).addClass('d-none');
          });


          $('.taskname').click(function() {
            var taskName = $(this).text(); // Get the task name
            var taskID = $(this).data('value');
           
            $.ajax({
              type: 'POST',
              url: 'process/process_fetchtaskdetails.php', 
              data: { 
                task_id: taskID, 
                task_name: taskName },
              success: function(response) {
                // Update off-canvas with the fetched task details
                $('.offcanvas-body').html(response);
                $('#offcanvasWithBothOptions').offcanvas('show'); // Show the off-canvas
              },
              error: function(xhr, status, error) {
                console.error(status + ": " + error);
  
              }
            });
          });

          $('.add-new-section').click(function(){
            // alert('You clicked me');
            var newSection = "";
          })
          $(document).on('change', '.offcanvas-body .subtask_checkbox', function() {
              alert("Checkbox changed");
          });


          $(document).on('change', '.offcanvas-body .subtask_checkbox2, .offcanvas-body .subtask_name2, .offcanvas-body .subtask_end_date2', function() {
            // alert("Change event triggered");
            var updateSubtaskNameInput = $(this).closest('.subtask-item').find('.subtask_name2');
            var updateSubtaskEndDateInput = $(this).closest('.subtask-item').find('.subtask_end_date2');
            var updateSubtaskStatusIdInput = $(this).closest('.subtask-item').find('.subtask_checkbox2');
            var updateSubtaskIdInput = $(this).closest('.subtask-item').find('.subtask_id2');
            var nFeedback = $('.offcanvas-body #nfeedback');
            var taskId = $('.offcanvas-body #task_id').text();

            var updateSubtaskName = updateSubtaskNameInput.val();
            var updateSubtaskEndDate = updateSubtaskEndDateInput.val();
            var updateSubtaskId = updateSubtaskIdInput.val();
            var updateSubtaskStatusId = updateSubtaskStatusIdInput.is(':checked') ? 1 : 0;
            // alert(updateSubtaskName + ' ' + updateSubtaskId + ' ' + updateSubtaskEndDate)

            if (updateSubtaskName !== '' && updateSubtaskEndDate !== '') {
              // Perform AJAX request to update subtask
            
              $.ajax({
                type: 'POST',
                url: 'process/process_update_subtask.php',
                data: {
                  task_id: taskId,
                  subtask_name: updateSubtaskName,
                  subtask_end_date:  updateSubtaskEndDate,
                  subtask_status_id: updateSubtaskStatusId,
                  subtask_id: updateSubtaskId,
                },
                success: function(response) {
                  // Update off-canvas with the fetched task details
                  if(response.status == 'success'){
                    $('.offcanvas-body #nfeedback').html(`response`);
                  }
                  
                
                },
                error: function(xhr, status, error) {
                  console.error(status + ": " + error);
    
                }
              });
            } else {
                $('.offcanvas-body #nfeedback').html('Subtask Name or Subtask End Date is empty');
                $('.offcanvas-body .subtask').addClass('d-none');
              }
          });


          $(document).on('click', '#add_subtask', function() {
            // Show subtask input fields
            $('.offcanvas-body .subtask').removeClass('d-none');

            var subtaskNameInput = $('.offcanvas-body .subtask_name');
            var subtaskEndDateInput = $('.offcanvas-body .subtask_end_date');
            var nFeedback = $('.offcanvas-body #nfeedback');
            var taskId = $('.offcanvas-body #task_id').text();

            // Focus on subtaskNameInput
            subtaskNameInput.focus();

            // Listen for focusout event on subtaskNameInput
            subtaskNameInput.on('focusout', function() {
                var subtaskName = subtaskNameInput.val();

                if (subtaskName !== '') {
                    nFeedback.text(''); // Clear the error message on valid subtask name
                } else {
                    // alert('Subtask name cannot be empty');
                    // return;
                }
                

                // Listen for change event on subtaskEndDateInput
                subtaskEndDateInput.on('change', function() {
                    var subtaskEndDate = subtaskEndDateInput.val();
                    var subtaskStatusId = $('.offcanvas-body #subtask_checkbox').is(':checked') ? 1 : 0;
              

                    if (taskId !== '' && subtaskEndDate !== '') {
                        // Perform AJAX request to add subtask
                        $.ajax({
                            type: 'POST',
                            url: 'process/process_add_subtask.php',
                            data: {
                                task_id: taskId,
                                subtask_name: subtaskName,
                                subtask_end_date: subtaskEndDate,
                                subtask_status_id: subtaskStatusId,
                            },
                            success: function(response) {
                  
                              if (response['status'] === 'success') {
                                  // Subtask added successfully
                                  $('.offcanvas-body #nfeedback').html(response.message);
                              } else {
                                  // Display error message
                                  console.log(response.message);
                              }
                            },
                            error: function(xhr, status, error) {
                                // Handle error response here (if needed)
                               console.log('Error: ' + error);
                            }
                        });
                    } else {
                        alert('Task ID or Subtask End Date is empty');
                        $('.offcanvas-body .subtask').addClass('d-none');
                    }
                });
            });
        });

          $("#submitTask").click(function(){

            var taskName = $("#taskName").val();
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
      

            $.ajax({
                type: 'POST',
                url: 'process/process_task.php',
                data: {
                    // sectionName: sectionName,
                    taskName: taskName,
                    startDate: startDate,
                    endDate: endDate
                },
                dataType: 'json',
                success: function(response) {
                  var taskName = $("#taskName").val("");
                  var startDate = $("#startDate").val("");
                  var endDate = $("#endDate").val("")
                  if(response.status == 'success'){
                    $('#feedback').html(`<div class="alert alert-success"> ${response.message}</div>`);
                }else{
                  $('#feedback').html(`<div class="alert alert-success"> ${response.message}</div>`);
                }},
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);
                }
            });
          })

          $(document).on('click', '#assign_btn', function() {
            $('.offcanvas-body #assign_to').removeClass('d-none');
              var taskID = $('.offcanvas-body #task_id').text();
              var assigneeID = $('.offcanvas-body #assign_to');

              assigneeID.on('change', function(){
                newAssigneeID = $('.offcanvas-body #assign_to  option:selected').val();

                $.ajax({
                  type: 'POST',
                  url: 'process/process_task_assignment.php',
                  data: {
                      task_id: taskID,
                      assign_to_id: newAssigneeID
                  },
                  dataType: 'json',
                  success: function(response) {
                    
                    if(response.status === 'success'){
                      $('.offcanvas-body #nfeedback').html(`<div class="alert alert-success"> ${response.message}</div>`);
                    }else{
                      $('.offcanvas-body #nfeedback').html(`<div class="alert alert-warning"> ${response.message}</div>`); 
                    }
                      },
                      error: function(xhr, status, error) {
                      // Handle errors
                      console.error('Error:', error);
                }
              });

            });
        
          })


            $(document).on('click', '#initiate_task_review', function() {
            var taskID = $('.offcanvas-body #task_id').text();
            var taskSection = $('.offcanvas-body #task_section option:selected').val();
            var taskStatus = $('.offcanvas-body #task_status').val();
            var taskReviewStatus = $('.offcanvas-body #task_review_status').val();
            if(taskReviewStatus == ''){
              var newTaskReviewStatus = 0;
            }else{
              var newTaskReviewStatus = taskReviewStatus;
            }
           
            $.ajax({
                type: 'POST',
                url: 'process/process_initiate_review.php',
                data: {
                    task_id: taskID,
                    task_status: taskStatus,
                    task_section: taskSection,
                    task_review_status: newTaskReviewStatus

                },
                dataType: 'json',
                success: function(response) {
                  if(response.status === 'success'){
                    ('.offcanvas-body #nfeedback').html(`<div class='alert alert-success'>${response.message}`);
                  } else {
                    ('.offcanvas-body #nfeedback').html(`<div class='alert alert-warning'>${response.message}`);
                  }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);
                }
            });
            })

            $(document).on('click', '#approve_task', function() {
            var taskID = $('.offcanvas-body #task_id').text();

            $.ajax({
                type: 'POST',
                url: 'process/process_task_approval.php',
                data: {
                    task_id: taskID
                },
                dataType: 'json',
                success: function(response) {
                  if (response.status === 'success') {
                  // Subtask added successfully
                    $('.offcanvas-body #nfeedback').html(`<div class='alert alert-success'>${response.message}`);
                    $('.offcanvas-body #task_review_status').val(`${response.review_status}`);
                    $('.offcanvas-body #task_approval_status').val(`${response.approval_status}`);
                    $('.offcanvas-body #task_section option[value="' + response.task_section + '"]').prop('selected', true);

                    $('.offcanvas-body #task_status').val(`${response.task_status}`);
                  } else {
                      // Display error message
                      $('.offcanvas-body #nfeedback').html(`<div class='alert alert-warning'>${response.message}`);
                  }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);
                }
            });
            })


            
            $(document).on('click', '#return_task', function() {
            var taskID = $('.offcanvas-body #task_id').text();

            $.ajax({
                type: 'POST',
                url: 'process/process_task_rejection.php',
                data: {
                    task_id: taskID
                },
                dataType: 'json',
                success: function(response) {
                  if (response.status === 'success') {
                  // Subtask added successfully
                  $('.offcanvas-body #nfeedback').html(`<div class='alert alert-success'>${response.message}`);
                  $('.offcanvas-body #task_review_status').val(`${response.review_status}`);
                    $('.offcanvas-body #task_approval_status').val(`${response.approval_status}`);
                    $('.offcanvas-body #task_section option[value="' + response.task_section + '"]').prop('selected', true);
                    $('.offcanvas-body #task_status').val(`${response.task_status}`);
                  } else {
                      // Display error message
                  $('.offcanvas-body #nfeedback').html(`<div class='alert alert-warning'>${response.message}`);
                  }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);
                }
            });
            })

            $(document).on('click', '#commentBtn', function() {
            var taskId = $('.offcanvas-body #task_id').text();
            var commentText = $('.offcanvas-footer #commentText').val();
              
            $.ajax({
                type: 'POST',
                url: 'process/process_task_comment.php',
                data: {
                    task_id: taskId,
                    comment_text:commentText
                },
                dataType: 'json',
                success: function(response) {
                  if (response.status === 'success') {
     
                    $('.offcanvas-body #nfeedback') . html(`${response.message}`);
                  } else {
                      // Display error message
                      alert(response.message);
                  }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error('Error:', error);
                }
            });
            })

            $(document).on('click', '#add_attachment', function() {
              $('.offcanvas-body #attached_files').removeClass('d-none');
              $('.offcanvas-body #add_attachment').addClass('d-none');
            })

            $(document).on('click', '#update_task_btn', function () {
                // Gather data from the form
                var taskID = $("#task_id").text().trim();
                var taskName = $("#task_name").val();
                var dueDate = $("#task_due_date").val();
                var section = $("#task_section").val();
                var startDate = $("#task_start_date").val();
                var description = $("#task_description").val();
                var update_task_btn = $("#update_task_btn").val();

                // Create FormData object
                var formData = new FormData();

                // Append data to FormData
                formData.append('task_id', taskID);
                formData.append('task_name', taskName);
                formData.append('task_due_date', dueDate);
                formData.append('task_section', section);
                formData.append('task_start_date', startDate);
                formData.append('task_description', description);
                formData.append('update_task_btn', update_task_btn);

                // Append attached files to FormData
                var attachedFiles = $("#attached_files")[0].files;
                for (var i = 0; i < attachedFiles.length; i++) {
                    formData.append('attached_files[]', attachedFiles[i]);
                }

                // AJAX request with FormData
                $.ajax({
                    type: "POST",
                    url: "process/process_update_taskdetails.php", 
                    data: formData,
                    processData: false, 
                    contentType: false,
                    dataType: 'json',
                    success: function (response) {
                        // Handle success
                        if(response.status == 'success')
                          {
                            $('.offcanvas-body #nfeedback').html(`<div class="alert alert-success">${response.message}</div>`);
                          }else
                          {
                            $('.offcanvas-body #nfeedback').html(`<div class="alert alert-warning">${response.message}</div>`);
                          
                          }
                          //refresh the off-canvas
                          $('.offcanvas-body').load();
                          //refresh the taskrow class
                          $('.taskrow').load(); 
                    },
                    error: function (error) {
                        // Handle error
                        $('.offcanvas-body #nfeedback').html(error);
                    }
                });
            });

            $(document).on('click', function(event) {
                // Check if the clicked element is outside the offcanvas
                if (!$(event.target).closest('.offcanvas').length && $('.offcanvas.show').length) {
                    // Reload the page if the click was outside the offcanvas and the offcanvas is currently shown
                    location.reload(true);
                }
            });
            
            $(document).on('click', '.offcanvas-header #closeBtn', function() {
              location.reload(true);
            })
          

          $('[data-toggle="popover"]').popover({
              placement : 'top',
              trigger : 'hover'
            });
            //Popover initialization
            var options = {
              html: true,
              content: $('[data-name="popover-content"]')
            };

            var exampleEl = document.getElementById('notification');

            //Create a new Bootstrap popover instance
            var popover = new bootstrap.Popover(exampleEl, options);
          });

          document.addEventListener("DOMContentLoaded", function() {
            var editableElement = document.querySelector(".editable");
            editableElement.addEventListener("click", function() {
            this.focus();
            });   
          });

          document.addEventListener('DOMContentLoaded', function () {
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasWithBothOptions'));

            myOffcanvas._element.addEventListener('shown.bs.offcanvas', function () {
                // Initialize popover after offcanvas is shown
                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
                var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl);
                  });
              });
          });
      

          document.addEventListener("DOMContentLoaded", function() {
            // Get all elements with the class 'newtaskcard'
            var draggableElements = document.querySelectorAll('.newtaskcard');
            var taskCols = document.querySelectorAll('.taskcol');

            // Add dragstart event listener to each draggable element
            draggableElements.forEach(function(draggable) {
                draggable.addEventListener('dragstart', function(e) {
                    // Set data to be transferred during the drag
                    e.dataTransfer.setData('text/plain', 'newtaskcard');
                    e.dataTransfer.setData('cardId', draggable.getAttribute('data-value'));

                    var cardId = draggable.querySelector('.taskname').getAttribute('data-value');
                    e.dataTransfer.setData('cardId', cardId);
                });
            });

            // Add dragover event listener to each taskcol
            taskCols.forEach(function(taskCol) {
                taskCol.addEventListener('dragover', function(e) {
                    // Prevent the default behavior to allow a drop
                    e.preventDefault();
                });
            });

        // Add drop event listener to each taskcol
        taskCols.forEach(function(taskCol) {
            taskCol.addEventListener('drop', function(e) {
                // Prevent the default behavior to allow a drop
                e.preventDefault();

                // Get the data that was set during the drag
                var draggedElementId = e.dataTransfer.getData('text/plain');
                var draggedCardId = e.dataTransfer.getData('cardId');

                // Check if the dragged element is the newtaskcard
                if (draggedElementId === 'newtaskcard') {

                    $.ajax({
                        type: 'POST',
                        url: 'process/process_update_task_section.php', 
                        data: {
                            task_id: draggedCardId,
                            new_section: taskCol.id
                        },
                        success: function(response) {
                            location.reload(true);
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            location.reload(true);
                            }
                        });
                    
                }
            });
        });

       
        });

    </script>
  </body>
</html>
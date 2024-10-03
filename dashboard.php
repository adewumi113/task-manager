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
        <h1>Dashboard</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          </ol>
        </nav>
          <?php
              require_once "partials/successmessage.php";
          ?>
          <?php
              require_once "partials/errormessage.php";
          ?>
          <div id="feedback"></div>
      </div><!-- End Page Title -->

      <section class="section">
          <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Tasks</h1>
                <a href="" class="d-none addTaskButton d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="popover"   data-bs-toggle="modal" data-bs-target="#taskModal" id="createNewTask"><i class="fas fa-download fa-sm text-white-50"></i> Create new task</a>
            </div>
                    
            <!-- Page Heading -->
            <div class="row">
              <?php if($tasks){ ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">Name</th>
                            <th scope="col">Section</th>
                            <th scope="col">Due date</th>
                            <th scope="col">Assigned to</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // echo('<pre>');
                        // print_r($tasks);
                        // echo('</pre>');
                        // // die();
                        $sn = 1;
                        
                        foreach($tasks as $task){ 
                        
                          ?>
                        
                        <tr class="single_task">
                            <td class="sn" data-value="<?php echo $task['task_id'] ?>"><?php echo $sn++ ?></td>
                            <td class="task_name"><?php echo $task['task_name'] ?></td>
                            <td><?php echo $task['task_section_name'] ?></td>
                            <td><?php echo $task['task_end_date'] ?></td>
                            <td><?php echo $task['user_firstname'] ?></td>
                            
                              <?php
                             
                              ?>
                            
                            <?php 
                              if($task['task_task_status_id'] == 2){
                                echo "<td class='text-primary fw-bold'>";
                                  if($task['task_status_name'] == ''){
                                    echo "N/A";
                                  }else{
                                    echo $task['task_status_name'];
                                  }
                                echo "</td>";
                              }else if($task['task_task_status_id'] == 3){
                                echo "<td class='text-success fw-bold'>";
                                if($task['task_status_name'] == ''){
                                  echo "N/A";
                                }else{
                                  echo $task['task_status_name'];
                                }
                                echo "</td>";
                              }else if($task['task_task_status_id'] == 4){
                                echo "<td class='text-danger fw-bold'>";
                                if($task['task_status_name'] == ''){
                                  echo "N/A";
                                }else{
                                  echo $task['task_status_name'];
                                }
                                echo "</td>";
                                
                              }else{
                                echo "<td class='text-black fw-bold'>";
                                if($task['task_status_name'] == ''){
                                  echo "N/A";
                                }else{
                                  echo $task['task_status_name'];
                                }
                                echo "</td>";
                              }
      
                            ?>
                            <td width="20%">
                                
                              <button class="btn btn-sm btn-primary view_details_btn" id="view_details_btn">View Details</button>
                                
                            </td>
                            
                        </tr>
                        <?php } }else if($user["user_role_id"] !== 5){
                          echo "<p>No tasks created by you or your team member(s) yet. Click the  <strong>Create new task</strong> button to create a task.</p>";
                        } else{
                          echo "<p>No tasks created or assigned to you yet. Click the  <strong>Create new task</strong> button to create a task.</p>";
                        }?>
                        <!-- Add more sample data as needed -->
                    </tbody>
                </table>
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
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="nfeedback"></div>
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
    <!-- End Footer -->    <script>
        $(document).ready(function(){

          $('.view_details_btn').click(function() {
            var taskName = $(this).closest('.single_task').find('.task_name').text();

            var taskID = $(this).closest('.single_task').find('.sn').data('value');
          
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
              $('.offcanvas-body #nfeedback').html(response);
            
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
                  alert('Subtask name cannot be empty');
                  return;
              }

              // Listen for change event on subtaskEndDateInput
              subtaskEndDateInput.on('change', function() {
                  var subtaskEndDate = subtaskEndDateInput.val();
                  var subtaskStatusId = $('#subtask_checkbox').is(':checked') ? 1 : 0;

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
                
                            if (response.status === 'success') {
                                // Subtask added successfully
                                $('.offcanvas-body #nfeedback').html(response.message);
                            } else {
                                // Display error message
                                alert(response.message);
                            }
                          },
                          error: function(xhr, status, error) {
                              // Handle error response here (if needed)
                              alert('Error: ' + error);
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
                if(response.status === 'success'){
                  
                  $('#feedback').html(`<div class="alert alert-success">${response.message}</div>`);
              }else{$('#feedback').html(`<div class="alert alert-warning">${response.message}</div>`); }
            },
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
              // alert(newAssigneeID + ' ' + taskID);
            $.ajax({
                type: 'POST',
                url: 'process/process_task_assignment.php',
                data: {
                    task_id: taskID,
                    assign_to_id: newAssigneeID
                },
                success: function(response) {
                  $('.offcanvas-body #nfeedback').html(response);
                  // $('.offcanvas-body #assign_to').addClass('d-none');
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
          $.ajax({
              type: 'POST',
              url: 'process/process_initiate_review.php',
              data: {
                  task_id: taskID
              },
              dataType: 'json',
              success: function(response) {
                if (response.status === 'success') {
                  $('.offcanvas-body #nfeedback').html(`<div class="alert alert-success">${response.message}</div>`);
                } else {
                // Display error message
                //     alert(response.message);
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
                success: function(response) {
                  // if (response.status === 'success') {
                  // // Subtask added successfully
                    $('.offcanvas-body #nfeedback').text(response);
                  // } else {
                  //     // Display error message
                  //     alert(response.message);
                  // }
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
                success: function(response) {
                  // if (response.status === 'success') {
                  // // Subtask added successfully
                    $('.offcanvas-body #nfeedback').text(response);
                  // } else {
                  //     // Display error message
                  //     alert(response.message);
                  // }
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
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting contentType
                    success: function (response) {
                        // Handle success
                        $('.offcanvas-body #nfeedback').text(response);
                    },
                    error: function (error) {
                        // Handle error
                        $('.offcanvas-body #nfeedback').html(error);
                    }
                });
            });

          $('#task_section').on('change', function() {
            // Get the selected value
            var taskSection = $(this).val();
            alert(taskSection)
            // Make AJAX request to update the database
            // $.ajax({
            //     type: 'POST',
            //     url: 'update_database.php', // Replace with the actual URL handling the update
            //     data: {
            //         assigneeID: assigneeID
            //     },
            //     success: function(response) {
            //         // Handle the success response if needed
            //         console.log(response);
            //     },
            //     error: function(xhr, status, error) {
            //         // Handle errors
            //         console.error('Error:', error);
            //     }
            // });
          });


         
  });

</script>
  </body>
</html>
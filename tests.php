<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <div class="col-lg-3 taskcol bg-secondary-subtle" style="width:360px">
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
        </div>
</body>
</html>
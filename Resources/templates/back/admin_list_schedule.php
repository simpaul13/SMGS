<div class="container">
    <h3>Schedule List</h3>
    <hr>
    <div class="d-flex justify-content-end mb-2">
        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i class="fas fa-plus-circle"></i> Create</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Section</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <form action="" method="post">
                <?php 
                    list_function_admin::Schedule_list(); 
                ?>
                </form>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create Schedule -->
<form action="" method="post">
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="exampleFormControlSelect1">Select Section</label>
                            <select class="form-control" id="exampleFormControlSelect1" required>
                                <option>Select</option>
                                <?php
                                    dropdown::section();
                                ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <label for="">Subject</label>
                        </div>
                        <div class="col-md-5">
                            <label for="">Classroom</label>
                        </div>
                        <div class="col-md-1">
                            <button type="button" name="add" id="add" class="btn btn-success btn-sm list_add"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>                   
                    <div id="list">
                        <div class="list_var">
                            <div class="form-row my-2">
                                <div class="col-md-5">
                                    <select class="form-control" id="exampleFormControlSelect1" name="subjectid[]" required>
                                        <option>Select Subject</option>
                                        <?php dropdown::subject() ?>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <select class="form-control" id="exampleFormControlSelect1" name="classroomid[]" required>
                                        <option>Select Classroom</option>
                                        <?php dropdown::classroom() ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button class="list_del btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary btn-sm">Create</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
$(function(){

  

  $('#list').addInputArea();

  
});
</script>
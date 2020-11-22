<div class="container">
    <h3>Subject List</h3>
    <hr>
    <div class="row">
      <div class="col-md-12">
        <input type="text" name="search_text" id="search_text" placeholder="Search Teacher" class="form-control" />
      </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>firstname</th>
                    <th>Middlename</th>
                    <th>Lastname</th>
                    <th>Started</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="result">
                <?php 
                    list_function_admin::teacher_list(); 
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    add_function_admin::subject_add();
?>
<!-- Modal -->
<form action="" method="post">
    <div class="modal fade bd-example-modal-lg" id="create" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="">Subject name</label>
                            <input type="text" name="subject_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="exampleFormControlSelect1">Example select</label>
                            <select class="form-control" name="subject_date" id="exampleFormControlSelect1">
                                <option></option>
                                <option value="M, W, F">M, W, F</option>
                                <option value="T,TH, S">T,TH, S</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Time Start</label>
                            <input type="text" name="subject_time_start" class="form-control timepicker" id="timepicker" required readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Time End</label>
                            <input type="text" name="subject_time_end" class="form-control timepicker" id="timepicker" required readonly>
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

$('#search_text').keyup(function(){

var search = $(this).val();

if(search != '') {
 load_data(search);
} else {
 load_data();
}

});

function load_data(query) {

$.ajax({
  url:"../../Resources/templates/back/admin_search_subject.php",
 method:"POST",
 data:{query:query},
 success:function(data) {
  $('#result').html(data);
 }
});

}

$(document).ready(function () {
    $('.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 60,
        minTime: '7',
        maxTime: '10:00pm',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
});
</script>
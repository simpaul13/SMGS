<div class="container">
    <h3>Schedule List</h3>
    <hr>
    <div class="row">
      <div class="col-md-10">
      <input type="text" name="search_text" id="search_text" placeholder="Search by Schedule" class="form-control" />

      </div>
      <div class="col-md-1">
        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i class="fas fa-plus-circle"></i> Create</a>
      </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Section</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="result">
                <?php 
                    list_function_admin::Schedule_list(); 
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Schedule view -->
<?php
    list_function_admin::Subject_list_A();
?>

<?php
    // this will go to the add schedule function
    add_function_admin::schedule_add();
    // this will go to the delete schedule function
    
?>
<!-- Modal Create Schedule -->
<form action="" method="post">
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
                            <select class="form-control" name="section_id" id="exampleFormControlSelect1" required>
                                <option>Select</option>
                                <?php
                                    dropdown::section();
                                ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 col-ms-12">
                            <form action="" method="post" id="insert_form">
                                <div class="table-repsonsive">
                                    <span id="error"></span>
                                    <table class="table table-bordered" id="item_table">
                                        <tr>
                                            <th>Teacher</th>
                                            <th>Subject</th>
                                            <th>Classroom</th>
                                            <th><button type="button" name="add" id="add" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></button></th>
                                        </tr>
                                        <tr id="row'+i+'">
                                            <td>
                                                <select class="form-control" id="exampleFormControlSelect1"
                                                    name="teacher_id[]" required>
                                                    <option>Select Teacher</option><?php dropdown::teacher() ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" id="exampleFormControlSelect1"
                                                    name="subject_id[]" required>
                                                    <option>Select Subject</option><?php dropdown::subject() ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" id="exampleFormControlSelect1"
                                                    name="classroom_id[]" required>
                                                    <option>Select Classroom</option><?php dropdown::classroom() ?>
                                                </select>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </form>
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

$(document).ready(function () {
    //Add more input field
    var i = 1;

    $('#add').click(function () {
        i++;
        $('#item_table').append('<tr id="row' + i + '"><td><select class="form-control" id="exampleFormControlSelect1" name="teacher_id[]" required><option>Select Teacher</option><?php dropdown::teacher() ?></select></td><td><select class="form-control" id="exampleFormControlSelect1" name="subject_id[]" required><option>Select Subject</option><?php dropdown::subject() ?></select></td><td><select class="form-control" id="exampleFormControlSelect1" name="classroom_id[]" required><option>Select Classroom</option><?php dropdown::classroom() ?></select></td><td><button name="remove" id="' + i + '"  class="btn_remove btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

    //Seacher Function
    $('#search_text').keyup(function () {

        var query = $(this).val();

        $.ajax({
            url: "../../Resources/templates/back/admin_search_schedule.php",
            method: "POST",
            data: {
                query: query
            },
            success: function (data) {
                $('#result').html(data);
            }
        });

    });

});
</script>
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


<!-- Modal -->
<form action="" method="post">
    <div class="modal fade bd-example-modal-lg" id="subject" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Subject Hold</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time Start</th>
                                <th scope="col">Time End</th>
                                <th scope="col">Classroom</th>
                                <th scope="col">Section</th>
                            </tr>
                        </thead>
                        <tbody class="list">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
$(function () {
    $('.btn-primary').click(function () {

        var id = $(this).attr('id');

        $.ajax({
            url: "../../Resources/templates/back/admin_list_modal_teacher_subject.php",
            method: "POST",
            data: {
                id: id
            },
            success: function (id) {
                $('#subject').modal('show');
                $('.list').html(id);
            }
        })

    });

    function subject_modal() {
        $('.btn-primary').click(function () {

            var id = $(this).attr('id');

            $.ajax({
                url: "../../Resources/templates/back/admin_list_modal_teacher_subject.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function (id) {
                    $('#subject').modal('show');
                    $('.list').html(id);
                }
            })

        });
    }

    $('#search_text').keyup(function () {

        var query = $(this).val();

        $.ajax({
            url: "../../Resources/templates/back/admin_search_teacher.php",
            method: "POST",
            data: {
                query: query
            },
            success: function (data) {
                $('#result').html(data);
                subject_modal();
            }
        });

    });
});
</script>
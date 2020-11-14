<div class="container">
    <h3>Classroom List</h3>
    <hr>
    <div class="d-flex justify-content-end mb-2">
        <a href="#" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Create</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Classroom</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            list_function_admin::class_list();
        ?>
        </tbody>
    </table>

</div>

<div class="container">
    <h3>Section List</h3>
    <hr>
    <div class="row">
      <div class="col-md-10">
      <input type="text" name="search_text" id="search_text" placeholder="Search by Section" class="form-control" />

      </div>
      <div class="col-md-1">
        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#create"><i class="fas fa-plus-circle"></i> Create</a>
      </div>
    </div>
    <br>
    <div class="table-responsive-ms">
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
                    list_function_admin::Section_list(); 
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
  // add function 
  add_function_admin::section_add()
?>
<!-- Modal -->
<form action="" method="post">
  <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Section</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-ms-12">
            <label for="">Section</label>
            <input type="text" name="section_name" class="form-control" required>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" name="submit"  class="btn btn-primary btn-sm">Create</button>
        </div>
      </div>
    </div>
  </div>
</form>
<script>
$('.btn-danger').click(function () {
   
   var a = $(this).attr('id');

   if (a != '') {
     Swal.fire({
       title: 'Are you sure?',
       text: "You won't be able to revert this!",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, delete it!'
     }).then((result) => {
       if (result.value) {
         load_data(a);
       }
     })
   }

   function load_data(id) {
     $.ajax({
       url: "index.php?section_delete",
       method: "POST",
       data: {
         id: id
       },
       dataType: "text",
       success: function (id) {
        Swal.fire({
          title: 'Successfully Deleted',
          text: "Successfully Delete for the database",
          icon: 'success',
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            window.location.replace("index.php?section");
          }
        })
       }
     });

   }
 });


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
        url:"../../Resources/templates/back/admin_search_section.php",
        method:"POST",
        data:{query:query},
        success:function(data) {
        $('#result').html(data);
      }
    });

  }
</script>
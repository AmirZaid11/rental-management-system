<?php include('db_connect.php'); ?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-4">
                <form action="" id="manage-house" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            House Form
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="msg"></div>
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label class="control-label">House No</label>
                                <input type="text" class="form-control" name="house_no" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Category</label>
                                <select name="category_id" class="custom-select" required>
                                    <?php 
                                    $categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
                                    if($categories->num_rows > 0):
                                    while($row = $categories->fetch_assoc()) :
                                    ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                    <?php endwhile; ?>
                                    <?php else: ?>
                                    <option selected="" value="" disabled="">Please check the category list.</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Description</label>
                                <textarea name="description" cols="30" rows="4" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Price</label>
                                <input type="number" class="form-control text-right" name="price" step="any" required="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">House Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                    <button class="btn btn-sm btn-default col-sm-3" type="reset"> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- FORM Panel -->

            <!-- Table Panel -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <b>House List</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">House</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $house = $conn->query("SELECT h.*,c.name as cname FROM houses h INNER JOIN categories c ON c.id = h.category_id ORDER BY id ASC");
                                while($row = $house->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td>
                                        <p>House #: <b><?php echo $row['house_no'] ?></b></p>
                                        <p><small>Type: <b><?php echo $row['cname'] ?></b></small></p>
                                        <p><small>Description: <b><?php echo $row['description'] ?></b></small></p>
                                        <p><small>Price: <b><?php echo number_format($row['price'],2) ?></b></small></p>
                                    </td>
                                    <td class="text-center">
                                        <?php if($row['image']): ?>
                                            <img src="uploads/<?php echo $row['image'] ?>" width="80px" height="80px">
                                        <?php else: ?>
                                            <p>No Image</p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary edit_house" type="button"
                                            data-id="<?php echo $row['id'] ?>"  
                                            data-house_no="<?php echo $row['house_no'] ?>" 
                                            data-description="<?php echo $row['description'] ?>" 
                                            data-category_id="<?php echo $row['category_id'] ?>" 
                                            data-price="<?php echo $row['price'] ?>"
                                            data-image="<?php echo $row['image'] ?>">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete_house" type="button" 
                                            data-id="<?php echo $row['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>
</div>

<script>
    $('#manage-house').submit(function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]); 
        $.ajax({
            url: 'ajax.php?action=save_house',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success:function(resp){
                if(resp == 1){
                    alert("Data successfully saved");
                    location.reload();
                } else if(resp == 2){
                    alert("House number already exists.");
                }
            }
        })
    });

    $('.edit_house').click(function(){
        var form = $('#manage-house');
        form[0].reset();
        form.find("[name='id']").val($(this).data('id'));
        form.find("[name='house_no']").val($(this).data('house_no'));
        form.find("[name='description']").val($(this).data('description'));
        form.find("[name='price']").val($(this).data('price'));
        form.find("[name='category_id']").val($(this).data('category_id'));
    });

    $('.delete_house').click(function(){
        if(confirm("Are you sure to delete this house?")){
            $.ajax({
                url:'ajax.php?action=delete_house',
                method:'POST',
                data:{id: $(this).data('id')},
                success:function(resp){
                    if(resp == 1){
                        alert("Data successfully deleted");
                        location.reload();
                    }
                }
            })
        }
    });

    $('table').dataTable();
</script>

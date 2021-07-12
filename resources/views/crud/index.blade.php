<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ajax CRud</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
</head>
<body>
    <div>
        <section class="content container mt-5">
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header bg-primary">
                              <h3>Product List</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Photo</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                  <div class="card">
                    <div class="card-header bg-primary">
                      <h3 class="card-title" id="addProduct">Add New product</h3>
                      <h3 class="card-title" id="updateProduct">Update product</h3>
                    </div>
                    <form role="form"  enctype="multipart/form-data">
                       <div class="card-body">
                        <!-- Email input -->
                            <div class="form-outline mb-4">
                              <div class="form-group">
                                    <label  for="postId" >Add New product</label>
                                    <input type="text" id="postId" class="form-control" placeholder="Add new product"/> 
                              </div>
                              <div class="form-group">
                                    <label for="descriptionId">Add New Description</label>
                                    <textarea type="text" id="descriptionId" class="form-control" placeholder="Add new Description"></textarea>
                              </div>
                              <div class="form-group">
                                    <label for="imageId">Add New Image</label>
                                    <input type="file" id="imageId">
                              </div>
                                <div class="form-group" >
                                    <label  for="priceid" >Add New price</label>
                                    <input type="number" id="priceid" class="form-control" placeholder="Add new price"/> 
                                </div>
                                <input type="hidden" id="id" class="form-control">
                            </div>
                        </div>
                        <!-- Submit button -->
                       <div class="card-footer ">
                            <button type="submit" id="addButton" class="btn btn-primary" onclick="addData()">Save</button>
                            <button type="submit" id="updateButton" class="btn btn-primary" onclick="updateData()">Update</button>
                       </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $('#addProduct').show();
        $('#addButton').show();
        $('#updateProduct').hide();
        $('#updateButton').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function allData(){
                $.ajax({
                type:"GET",
                dataType:"Json",
                url:"/product/all/",
                success:function(response){
                   var data=""
                   var count="1"
                   $.each(response,function(key,value){
                       data= data + "<tr>"
                       data= data + "<td>"+count+++"</td>"
                       data= data + "<td>"+value.name+"</td>"
                       data= data + "<td>"+value.description+"</td>"
                       data= data + "<td>"+value.photo+"</td>"
                       data= data + "<td>"+value.price+"</td>"
                       data= data + "<td>"
                       data= data + "<button class='btn btn-warning mr-2 btn-sm px-3' onclick='editData("+value.id+")'><i class='fas fa-edit'></i></button>"
                       data= data + "<button class='btn btn-danger btn-sm px-3 mr-2' onclick='deleteData("+value.id+")'><i class='fas fa-times'></i></button>"
                       data= data + "<button class='btn btn-primary btn-sm px-3 mr-2' id='active' onclick='active()'>Active</button>"
                       data= data + "</td>"
                       data= data + "</tr>"
                   })
                   $('tbody').html(data);
                }
            })
        }
        allData();

        function clearData(){
            $('#postId').val('');
            $('#descriptionId').val('');
            $('#priceid').val('');
            $('#imageId').val('');
        }

        function addData(){
            var name= $('#postId').val();
            var description= $('#descriptionId').val();
            var price= $('#priceid').val();
            var image= $('#imageId').val();
            
            $.ajax({
                type:"POST",
                dataType:"Json",
                data:{name:name, description:description, price:price, image:image},
                url:"/product/store/",
                success: function(data){
                    clearData();
                    allData();
                    console.log("successfully data added");
                }
            })
        }

        function editData(id){
            $.ajax({
                type:"GET",
                dataType:"Json",
                url:"/product/edit/"+id,
                success:function(data){
                    $('#addProduct').hide();
                    $('#addButton').hide();
                    $('#updateProduct').show();
                    $('#updateButton').show();
                    $('#postId').val(data.name);
                    $('#descriptionId').val(data.description);
                    $('#priceid').val(data.price);
                    $('#id').val(data.id);
                    console.log(data);
                }
            })
        }

        function updateData(){
            var id= $('#id').val();
            var name= $('#postId').val();
            var description= $('#descriptionId').val();
            var price= $('#priceid').val();

            $.ajax({
                type:"POST",
                dataType:"Json",
                data:{name:name, description:description, price:price},
                url:"/product/update/"+id,
                success:function(data){
                    console.log('data updated');
                }
            })
        }

        function deleteData(id){
            $.ajax({
                type:"GET",
                dataType:"Json",
                url:"/product/delete/"+id,
                success:function(data){
                    clearData();
                    allData();
                    console.log('data deleted');
                }
            })
        }

    </script>
</body>



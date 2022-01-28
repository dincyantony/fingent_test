<!DOCTYPE html>
<html>
<head>
   <title>Employees CSV </title>

   <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

   <div class="container">

     <div class="row">
       <div class="col-md-12">
          <?php 
          // Display Response
          if(session()->has('message')){
          ?>
             <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                <?= session()->getFlashdata('message') ?>
             </div>
          <?php
          }
          ?>

          <?php $validation = \Config\Services::validation(); ?>

          <form method="post" action="<?=site_url('employees/importFile')?>" enctype="multipart/form-data">

             <?= csrf_field(); ?>
             <div class="form-group">
                <label for="file">File:</label>

                <input type="file" class="form-control" id="file" name="file" />
                <!-- Error -->
                <?php if( $validation->getError('file') ) {?>
                <div class='alert alert-danger mt-2'>
                   <?= $validation->getError('file'); ?>
                </div>
                <?php }?>

             </div>

             <input type="submit" class="btn btn-success" name="submit" value="Import CSV">
          </form>
       </div>
     </div>

     <div class="row">

        <!-- Users list -->
        <div class="col-md-12 mt-4" >

           <h3 class="mb-4">Employees List</h3>
           <table width="100%">
              <thead>
                 <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Age</th>
                    <th>Experience</th>
                 </tr>
              </thead>
              <tbody>
                 <?php 
                 if(isset($employees) && count($employees) > 0){
                     foreach($employees as $emp){
                 ?>
                       <tr>
                          <td><?= $emp['id'] ?></td>
                          <td><?= $emp['emp_code'] ?></td>
                          <td><?= $emp['emp_name'] ?></td>
                          <td><?= $emp['designation'] ?></td>
                          <td><?= $emp['age'] ?></td>
                          <td><?= $emp['experience'] ?></td>
                       </tr>
                 <?php
                     }
                 }else{
                 ?>
                     <tr>
                        <td colspan="5">No record found.</td>
                     </tr>
                 <?php
                 }
                 ?>
             </body>
           </table>
        </div>

     </div>
   </div>

</body>
</html>
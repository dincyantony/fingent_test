<?php namespace App\Controllers;

use App\Models\Employees;

class EmployeesController extends BaseController{
   public function index()
    {
      $employee = new Employees();
        $data['employee_details'] = $employee->get()->getResultArray();
        return view('employee',$data);

    }
    public function create()
    {

        return view('create');
    }
    public function store_employee()
    {
      $form_data = $this->request->getPost();
      $employee = new Employees();
      $form_data['age'] = date_diff(date_create($form_data['age']), date_create(date('Y-m-d')))->y;
      $form_data['experience'] = date_diff(date_create($form_data['experience']), date_create(date('Y-m-d')))->y;
      // echo "<pre>";
      // print_r($form_data);
      // die();
      $employee->save($form_data);
      return redirect()->to('/');
    }

   public function csv_index(){
      ## Fetch all records
      $users = new Employees();
      $data['employees'] = $users->findAll();

      return view('employees/index',$data);
   }

   // File upload and Insert records
   public function importFile(){

      // Validation
      $input = $this->validate([
         'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,csv],'
      ]);

      if (!$input) { // Not valid
         $data['validation'] = $this->validator;

         return view('employees/index',$data); 
      }else{ // Valid

         if($file = $this->request->getFile('file')) {
            if ($file->isValid() && ! $file->hasMoved()) {

               // Get random file name
               $newName = $file->getRandomName();

               // Store file in public/csvfile/ folder
               $file->move('../public/csvfile', $newName);

               // Reading file
               $file = fopen("../public/csvfile/".$newName,"r");
               $i = 0;
               $numberOfFields = 5; // Total number of fields

               $importData_arr = array();

               // Initialize $importData_arr Array
               while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                  $num = count($filedata);

                  // Skip first row & check number of fields
                  if($i > 0 && $num == $numberOfFields){ 
                     
                     // Key names are the insert table field names - name, email, city, and status
                     $importData_arr[$i]['emp_code'] = $filedata[0];
                     $importData_arr[$i]['emp_name'] = $filedata[1];
                     $importData_arr[$i]['designation'] = $filedata[2];
                     $importData_arr[$i]['age'] =  date_diff(date_create($filedata[3]), date_create(date('Y-m-d')))->y;
                     $importData_arr[$i]['experience'] =  date_diff(date_create($filedata[4]), date_create(date('Y-m-d')))->y;

                  }

                  $i++;

               }
               fclose($file);
 
               // Insert data
               $count = 0;
               foreach($importData_arr as $userdata){
                  $users = new Employees();

                  // Check record
                  $checkrecord = $users->where('emp_code',$userdata['emp_code'])->countAllResults();

                  if($checkrecord == 0){

                     ## Insert Record
                     if($users->insert($userdata)){
                         $count++;
                     }
                  }

               }

               // Set Session
               session()->setFlashdata('message', $count.' Record inserted successfully!');
               session()->setFlashdata('alert-class', 'alert-success');

            }else{
               // Set Session
               session()->setFlashdata('message', 'File not imported.');
               session()->setFlashdata('alert-class', 'alert-danger');
            }
         }else{
            // Set Session
            session()->setFlashdata('message', 'File not imported.');
            session()->setFlashdata('alert-class', 'alert-danger');
         }

      }

      return redirect()->route('/'); 
   }
}
<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert([
        ['name' => 'Admin','guard_name'=>'web'], //1
        //users who are sending request and viewing
        ['name' => 'Department Head','guard_name'=>'web'], //2
        ['name' => 'Section Head','guard_name'=>'web'], //3
        // ['name' => 'Faculty','guard_name'=>'web'], //4
        //persons with approve privilege
        ['name' => 'BAC Secretary','guard_name'=>'web'], //5
        ['name' => 'Budget Officer','guard_name'=>'web'], //6
        ['name' => 'Campus Director','guard_name'=>'web'], //7
        ['name' => 'ADAA','guard_name'=>'web'], //8
        ['name' => 'Procurement','guard_name'=>'web'], //9
        ['name' => 'Supplies','guard_name'=>'web'], //10
        ['name' => 'BAC Chairperson','guard_name'=>'web'], //11
        ]);

        DB::table('departments')->insert([
        ['department_name' => 'Electrical and Allied'],                         //1
        ['department_name' => 'Civil and Allied'],                              //2
        // ['department_name' => 'Administration'],                                //
        ['department_name' => 'Mechanical and Allied'],                         //3
        ['department_name' => 'Bachelor of Engineering & Allied Department'],   //4


        ]);
        // courses and budget must be the same for budget allocation
        DB::table('courses')->insert([
        //1 Electrical & Allied
        ['course_name' => 'Computer Engineering Technology', 'department_id' => '1'], //1
        ['course_name' => 'Electrical Engineering Technology', 'department_id' => '1'], //2
        ['course_name' => 'Electronics Engineering Technology', 'department_id' => '1'], //3
        ['course_name' => 'Bachelor of Technology in Information Technology', 'department_id' => '1'], //4
        ['course_name' => 'Bachelor of Science in  Electronics Engineering', 'department_id' => '1'], //5
        ['course_name' => 'Bachelor of Science in  Electrical Engineering', 'department_id' => '1'], //6
        //2 Civil & Allied
        ['course_name' => 'Civil Engineering Technology', 'department_id' => '2'],
        ['course_name' => 'Architecture Engineering Technology', 'department_id' => '2'],
        ['course_name' => 'Chemical Engineering Technology', 'department_id' => '2'],
        ['course_name' => 'Bachelor of Science in in Environmental Science', 'department_id' => '2'],
        ['course_name' => 'Bachelor of Science in Civil Engineering', 'department_id' => '2'],
        ['course_name' => 'Bachelor of Science in Civil Engineering', 'department_id' => '2'],
        ['course_name' => 'Bachelor of Science in Civil Engineering', 'department_id' => '2'],
        //4 Mechanical & Allied
        ['course_name' => 'Mechanical Engineering Technology', 'department_id' => '3'],
        ['course_name' => 'Automotive Engineering Technology', 'department_id' => '3'],
        ['course_name' => 'Bachelor of Science in Mechanical Engineering', 'department_id' => '3'],
        ['course_name' => 'Automotive Engineering Technology', 'department_id' => '3'],
        //5 BOE & Allied
        ['course_name' => 'Instrumentation and Control Engineering Technology', 'department_id' => '4'],
        ['course_name' => 'NDT Engineering Technology', 'department_id' => '4'],
        ['course_name' => 'RAC Engineering Technology', 'department_id' => '4'],
        ['course_name' => 'Tool Engineering Technology', 'department_id' => '4'],
        ['course_name' => 'Electromechanical Engineering Technology', 'department_id' => '4'],
        ]);


        DB::table('users')->insert([
        [
        	'title' => 'Mr.',
            'first_name' => 'admin', 
            'last_name' => 'Sempai', 
            'username' => 'admin', 
            'password' => bcrypt('qweasd'), 
            'department_id' => null,
            'course_id' => null,
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [ 
            'title' => 'Mr.',  
            'first_name' => 'Eriq', 
            'last_name' => 'Mendoza', 
            'username' => 'eriq', 
            'password' => bcrypt('qweasd'), 
            'department_id' => null,
            'course_id' => null,
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [ 
            'title' => 'Ms.',  
            'first_name' => 'Karen', 
            'last_name' => 'Calulo', 
            'username' => 'karen', 
            'password' => bcrypt('qweasd'), 
            'department_id' => '1',
            'course_id' => '1',
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [ 
            'title' => 'Engr.',  
            'first_name' => 'ADAA', 
            'last_name' => 'ADAA', 
            'username' => 'adaa', 
            'password' => bcrypt('qweasd'), 
            'department_id' => null,
            'course_id' => null,
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [ 
            'title' => 'Dr.',  
            'first_name' => 'Campus', 
            'last_name' => 'Director', 
            'username' => 'cd', 
            'password' => bcrypt('qweasd'), 
            'department_id' => null,
            'course_id' => null,
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [ 
            'title' => 'Mr.',  
            'first_name' => 'Al', 
            'last_name' => 'Lapastora', 
            'username' => 'al', 
            'password' => bcrypt('qweasd'), 
            'department_id' => null,
            'course_id' => null,
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [ 
            'title' => 'Mr.',  
            'first_name' => 'Bac', 
            'last_name' => 'Chairperson', 
            'username' => 'bacc', 
            'password' => bcrypt('qweasd'), 
            'department_id' => null,
            'course_id' => null,
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [ 
            'title' => 'Mr.',  
            'first_name' => 'Dept', 
            'last_name' => 'Head', 
            'username' => 'dh', 
            'password' => bcrypt('qweasd'), 
            'department_id' => 1,
            'course_id' => 1,
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [ 
            'title' => 'Mr.',  
            'first_name' => 'Proc', 
            'last_name' => 'curement', 
            'username' => 'proc', 
            'password' => bcrypt('qweasd'), 
            'department_id' => null,
            'course_id' => null,
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        [ 
            'title' => 'Mr.',  
            'first_name' => 'Sup', 
            'last_name' => 'plies', 
            'username' => 'sup', 
            'password' => bcrypt('qweasd'), 
            'department_id' => null,
            'course_id' => null,
            'active' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],
        ]);


        DB::table('model_has_roles')->insert([
        ['role_id'=>1,'model_type'=>'App\User','model_id'=>1],
        ['role_id'=>2,'model_type'=>'App\User','model_id'=>8],
        ['role_id'=>3,'model_type'=>'App\User','model_id'=>3],
        ['role_id'=>4,'model_type'=>'App\User','model_id'=>6],
        ['role_id'=>5,'model_type'=>'App\User','model_id'=>2],
        ['role_id'=>6,'model_type'=>'App\User','model_id'=>5],
        ['role_id'=>7,'model_type'=>'App\User','model_id'=>4],
        ['role_id'=>8,'model_type'=>'App\User','model_id'=>9],
        ['role_id'=>9,'model_type'=>'App\User','model_id'=>10],
        ['role_id'=>10,'model_type'=>'App\User','model_id'=>7],
        ]);
    }
}

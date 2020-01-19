            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>Subheading</small>
                        </h1>

                        <?php
                        
                            // $found_user = User::find_by_id(8);

                            // echo $found_user->username;


                            // $photo = Photo::find_by_id(6);

                            // echo $photo->filename;


                            // $result_set = user::find_all_users();
                                // while($row = mysqli_fetch_array($result_set)) {
                                //     echo $row['username'] . "<br>";
                                // }
                            
                            
                            // $found_user = user::find_by_id(3);

                                // $user = User::instantation($found_user);

                                // echo $user->username;

                                // echo "<br>";


                            // $users = user::find_all();
                                // foreach($users as $user) {
                                //     echo $user->username. "<br>";
                                //     echo $user->id. "<br>";
                                // }

                                // $found_user = User::find_by_id(3);
                                // echo $found_user->username;

                            // *****create:
                                // // estantiate the user class:
                                // $user = new User();
                                
                                //     // assigned static strings for the object:
                                //     $user->username = 'mili';
                                //     $user->password = '1234';
                                //     $user->first_name = 'milagros';
                                //     $user->last_name = 'mor';

                                //     // use the method:
                                //     $user->create();


                            // *****update
                                // we dont need the instance we're just calling the method:
                                // $user = User::find_by_id(11);
                                // $user->password = "333";

                                // $user->update();


                            // *****mydelete
                                // estantiate the user class:
                                // $user = new User();
                                
                                //     // assigned static strings for the object:
                                //     $user->username = 'example_username';
                                //     $user->password = 'example_password';
                                //     $user->first_name = 'John';
                                //     $user->last_name = 'Doe';

                                // $user->delete();


                            // *****delete
                                // estantiate the user class:
                                // $user = User:: find_by_id(3);
                                
                                // $user->delete();


                            // save
                                    // when the id is already there- it suppose to update
                                // $user = User:: find_by_id(8);
                                
                                // $user->username = "barbi";
                                // $user->password = "1234";
                                // $user->first_name = "gal";
                                // $user->last_name = "cat";

                                // $user->save();

                                    // when the id is not there- it suppose to create
                                    
                                // $user = new User();
                                
                                // $user->username = "new_user";

                                // $user->save();


                            // $users = User::find_all();

                                // foreach($users as $user)  {
                                //     echo $user->username . "<br>";
                                // }


                            // $photos = Photo::find_all();

                                // foreach($photos as $photo)  {
                                //     echo $photo->title . "<br>";
                                // }


                            // *****create:
                                // // estantiate the user class:
                                // $photo = new Photo();
                                
                                // // assigned static strings for the object:
                                // $photo->title = 'some title';
                                // $photo->description = 'description';
                                // $photo->filename = 'filename.jpg';
                                // $photo->type = 'image';
                                // $photo->size = 20;

                                // // use the method:
                                // $photo->create();

                                // echo INCLUDES_PATH.""

                        ?>



                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
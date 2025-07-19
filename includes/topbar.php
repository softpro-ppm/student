  <nav class="navbar top-navbar bg-white box-shadow">
            	<div class="container-fluid">
                    <div class="row">
                        <div class="navbar-header no-padding">
                			<a class="navbar-brand" href="dashboard.php">
                			    SOFTPRO | <?php if($_SESSION['user_type'] == '1'){ echo "Admin"; }else{ echo "MIS"; } ?>
                			</a>
                            <span class="small-nav-handle hidden-sm hidden-xs"><i class="fa fa-outdent"></i></span>
                			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                				<span class="sr-only">Toggle navigation</span>
                				<i class="fa fa-ellipsis-v"></i>
                			</button>
                            <button type="button" class="navbar-toggle mobile-nav-toggle" >
                				<i class="fa fa-bars"></i>
                			</button>
                		</div>
                        <!-- /.navbar-header -->

                		<div class="collapse navbar-collapse" id="navbar-collapse-1">
                			<ul class="nav navbar-nav" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <li class="hidden-sm hidden-xs"><a href="#" class="user-info-handle"><i class="fa fa-user"></i></a></li>
                                <li class="hidden-sm hidden-xs"><a href="#" class="full-screen-handle"><i class="fa fa-arrows-alt"></i></a></li>
                       
                				<li class="hidden-xs hidden-xs"><!-- <a href="#">My Tasks</a> --></li>

                               
                			</ul>
                            <!-- /.nav navbar-nav -->

                			<ul class="nav navbar-nav navbar-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                                <?php
                                // Prepare the query to count the rows
                                    $sql = "SELECT COUNT(*) AS count FROM emi_list WHERE added_type = 2";
                                    $stmt = $dbh->prepare($sql);
                                    $stmt->execute();

                                    // Fetch the result
                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $count = $result['count'];

                                    //print_r($_SESSION);

                                   // echo "Total records with added_type 2: " . $count;
                                ?>
                                    <?php // if($_SESSION['user_type']==1){ ?>
                				        <li><a href="pending_payment_approval.php" class="color-danger text-center"><i class="fa fa-credit-card"></i> Pending Approval (<?=$count?>)</a></li>
                                    <?php // } ?>

                				    <li><a href="logout.php" class="color-danger text-center"><i class="fa fa-sign-out"></i> Logout</a></li>
                                    
                					
                		
                            
                			</ul>
                            <!-- /.nav navbar-nav navbar-right -->
                		</div>
                		<!-- /.navbar-collapse -->
                    </div>
                    <!-- /.row -->
            	</div>
            	<!-- /.container-fluid -->
            </nav>

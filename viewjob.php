<section id="content">
    <div class="container content">

        <?php
        if (isset($_GET['search'])) {
            $jobid = $_GET['search'];
        } else {
            $jobid = '';
        }

        $sql = "SELECT * FROM `tblcompany` c, `tbljob` j WHERE c.`COMPANYID`=j.`COMPANYID` AND JOBID LIKE '%" . $jobid . "%' ORDER BY DATEPOSTED DESC";
        $mydb->setQuery($sql);
        $cur = $mydb->loadResultList();

        foreach ($cur as $result) {
        ?>

            <!-- Your job listing HTML code here -->
            <div class="container">
                <div class="mg-available-rooms">
                    <h5 class="mg-sec-left-title">Date Posted: <?php echo date_format(date_create($result->DATEPOSTED), 'M d, Y'); ?></h5>
                    <div class="mg-avl-rooms">
                        <div class="mg-avl-room">
                            <div class="row">
                                <div class="col-sm-2">
                                    <a href="#"><span class="fa fa-building-o" style="font-size: 50px"></span><!-- <img src="img/room-1.png" alt="" class="img-responsive"> --></a>
                                </div>
                                <div class="col-sm-10">
                                    <div style="border-bottom: 1px solid #ddd;padding: 10px;font-size: 25px;font-weight: bold;color: #000;margin-bottom: 5px;"><?php echo $result->OCCUPATIONTITLE; ?>
                                    </div>
                                    <div class="row contentbody">
                                        <div class="col-sm-6">
                                            <ul>
                                                <li><i class="fp-ht-bed"></i>Required No. of Employee's : <?php echo $result->REQ_NO_EMPLOYEES; ?></li>
                                                <li><i class="fp-ht-food"></i>Salary : <?php echo number_format($result->SALARIES, 2);  ?></li>
                                                <li><i class="fa fa-sun-"></i>Duration of Employment : <?php echo $result->DURATION_EMPLOYEMENT; ?></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6">
                                            <ul>
                                                <!-- <li><i class="fp-ht-dumbbell"></i>Qualification/Work Experience : <?php echo $result->QUALIFICATION_WORKEXPERIENCE; ?></li> -->
                                                <li><i class="fp-ht-tv"></i>Prefered Sex : <?php echo $result->PREFEREDSEX; ?></li>
                                                <li><i class="fp-ht-computer"></i>Sector of Vacancy : <?php echo $result->SECTOR_VACANCY; ?></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-12">
                                            <p>Qualification/Work Experience :</p>
                                            <ul style="list-style: none;">
                                                <li><?php echo $result->QUALIFICATION_WORKEXPERIENCE; ?></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-12">
                                            <p>Job Description:</p>
                                            <ul style="list-style: none;">
                                                <li><?php echo $result->JOBDESCRIPTION; ?></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-12">
                                            <p>Employer : <?php echo  $result->COMPANYNAME; ?></p>
                                            <p>Location : <?php echo  $result->COMPANYADDRESS; ?></p>
                                        </div>
                                    </div>
                                    <!-- Apply Now Button -->
                                    <a href="<?php echo web_root; ?>index.php?q=apply&job=<?php echo $result->JOBID; ?>&view=personalinfo" class="btn btn-main btn-next-tab">Apply Now!</a>
                                </div>
                            </div>

                        <?php
                        // Store the views in the Views table
                        if (isset($_SESSION['APPLICANTID']) && is_numeric($_SESSION['APPLICANTID'])) {
                            $applicantID = (int)$_SESSION['APPLICANTID'];
                            $jobID = (int)$result->JOBID;

                            // Check if a record with the same 'applicant_id' and 'job_id' exists in the Views table
                            $sql = "SELECT * FROM Views WHERE applicant_id = $applicantID AND job_id = $jobID";
                            $mydb->setQuery($sql);
                            $view = $mydb->loadSingleResult();

                            if ($view) {
                                // If the record exists, update the 'visit_count'
                                $visitCount = $view->visit_count + 1;
                                $sql = "UPDATE Views SET visit_count = $visitCount WHERE applicant_id = $applicantID AND job_id = $jobID";
                                $mydb->setQuery($sql);
                                $mydb->executeQuery();
                            } else {
                                // If the record doesn't exist, insert a new record with 'visit_count' set to 1
                                $sql = "INSERT INTO Views (applicant_id, job_id, visit_count) VALUES ($applicantID, $jobID, 1)";
                                $mydb->setQuery($sql);
                                $mydb->executeQuery();
                            }
                        }
                    }
                        ?>

                        </div>
</section>
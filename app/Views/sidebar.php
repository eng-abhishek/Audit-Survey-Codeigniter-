<?php
    if($_SESSION['user_type'] == ROLE_SA)
    {
        $userlabel = 'Admin';
    }
    else
    {
        $userlabel = $_SESSION['user_type']." USER";   
    }
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>" class="brand-link">
        <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="<?php echo config('AuditSurvey')->siteName; ?>" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><br></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url('assets/images/avatar-male.png'); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo base_url(); ?>" class="d-block"><?php echo $userlabel; ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

               <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_users)) { ?>
               <li class="nav-item">
                    <a href="<?php echo base_url('users'); ?>" class="nav-link <?php echo (service('request')->uri->getSegment(1) == "users" && (service('request')->uri->getSegment(2) == "" || service('request')->uri->getSegment(2) == "add" || service('request')->uri->getSegment(2) == "edit" || service('request')->uri->getSegment(2) == "view")) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Users</p>
                    </a>
                </li>
            <?php } ?>
            
            <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_user_group)) { ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('users/groups'); ?>" class="nav-link <?php echo (service('request')->uri->getSegment(1) == "users" && service('request')->uri->getSegment(2) == "groups") ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>User Groups</p>
                    </a>
                </li>
               <?php } ?> 
                <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_invites_approvals)) { ?>
			     <li class="nav-item <?php echo (service('request')->uri->getSegment(1) == "users" || service('request')->uri->getSegment(2) == "groups") ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Invites and Approvals
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('oac-invites'); ?>" class="nav-link <?php echo (service('request')->uri->getSegment(1) == "oac-invites" && (service('request')->uri->getSegment(2) == "" || service('request')->uri->getSegment(2) == "add" || service('request')->uri->getSegment(2) == "edit" || service('request')->uri->getSegment(2) == "view")) ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Invite OAC</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('oac-invites/list-approvals'); ?>" class="nav-link <?php echo (service('request')->uri->getSegment(1) == "users" && service('request')->uri->getSegment(2) == "groups") ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Approvals (<?php echo isset($unapproved_count) ? $unapproved_count : "0"; ?>)</p>
                            </a>
                        </li>
                    </ul>
                </li>	
                <?php } ?>

                <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_survey)) { ?>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-square"></i>
                        <p>
                            Surveys
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('surveytemplate'); ?>" class="nav-link">
                                <i class="fas fa-th-large nav-icon"></i>
                                <p>Templates</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('survey'); ?>" class="nav-link">
                                <i class="fas fa-question nav-icon"></i>
                                <p>Create Survey</p>
                            </a>
                        </li>

                    </ul>
                </li>
            <?php } ?>

              <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_survey_response)) { ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url('users'); ?>" class="nav-link">
                                    <i class="far fa-check-square nav-icon"></i>
                                    <p>Responses</p>
                                </a>
                            </li>
                        <?php } ?>
                <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_districts)) { ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('districts'); ?>" class="nav-link <?php echo (service('request')->uri->getSegment(1) == "districts") ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-school"></i>
                        <p>Districts</p>
                    </a>
                </li>
            <?php } ?>
                <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_companies)) { ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('bus-companies'); ?>" class="nav-link <?php echo (service('request')->uri->getSegment(1) == "bus-companies") ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-bus"></i>
                        <p>Bus Companies</p>
                    </a>
                </li>
                <?php } ?>

                <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('bus-routes'); ?>" class="nav-link <?php echo (service('request')->uri->getSegment(1) == "bus-routes") ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-bus"></i>
                        <p>School Bus Routes</p>
                    </a>
                </li>
                <?php } ?>
                
                <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_school_destination)) { ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('school-destination'); ?>" class="nav-link <?php echo (service('request')->uri->getSegment(1) == "school-destination") ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-bus"></i>
                        <p>School Destination</p>
                    </a>
                </li>
            <?php } ?>

                <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_students)) { ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('student');?>" class="nav-link">
                        <i class="nav-icon fas fa-child"></i>
                        <p class="text">Manage Students</p>
                    </a>
                </li>
                <?php } ?>

              <?php if(in_array(session('user_type'),config('AuditSurvey')->menu_school_calender)) { ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('school-calendar');?>" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p class="text">School Calendar</p>
                    </a>
                </li>
                <?php } ?>  

            </ul>
            <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
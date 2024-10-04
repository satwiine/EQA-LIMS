
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <?php if($_SESSION['usercat']=='1'){                  ///administrator
          ?>
          <li class="treeview" id="settingsNav">
              <a href="#">
                <i class="fa fa-gears"></i>
                <span>Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu separator">
                
                <li id="manageFacility"><a href="<?php echo base_url('manageFacility'); ?>"><i class="fa fa-institution"></i> Facilities</a></li>
                
                <li id="manageTester"><a href="<?php echo base_url('manageTester'); ?>"><i class="fa fa-users"></i>  Testers</a></li>
                <li id="manageHub"><a href="<?php echo base_url('manageHub'); ?>"><i class="fa fa-github-square"></i>  Hubs</a></li>
                <!--li id="manageCycle"><a href="<?php // echo base_url('manageexpectedResult'); ?>"><i class="fa fa-arrow-circle-o-down"></i> Expected Results</a></li-->
                <li id="manageRegion"><a href="<?php echo base_url('manageRegion'); ?>"><i class="fa fa-hospital-o"></i>  Regions</a></li>
                <li id="manageDistrict"><a href="<?php echo base_url('manageDistrict'); ?>"><i class="fa fa-y-combinator"></i>  Districts</a></li>
                <li id="manageCadre"><a href="<?php echo base_url('manageCadre'); ?>"><i class="fa fa-user-md"></i>Title</a></li>
                <li id="manageTileCategory"><a href="<?php echo base_url('manageTitleCategory'); ?>"><i class="fa fa-user-md"></i>Title Category</a></li>

                <li id="manageCycle"><a href="<?php echo base_url('manageCycle'); ?>"><i class="fa fa-arrow-circle-o-down"></i>  Cycles</a></li>
                <li id="upload_excel"><a href="<?php echo base_url('importDistro') ?>"><i class="fa fa-github-square"></i> Import Distribution</a></li>
                <li id="upload_excel"><a href="<?php echo base_url('addcycleresult') ?>"><i class="fa fa-github-square"></i> Add Cycle Results</a></li>

                <li id="listUndispatchedResultsNav"><a href="<?php echo base_url('recDispatch'); ?>"><i class="fa fa-circle-o"></i> Recency Results Dispatch</a></li>
                <li id="backup_uvri_pt_db" style="display:none;"><a href="<?php echo base_url('dbBackup');?>"><i class="fa fa-backup"></i>Backup Database</a></li>
                <li id="snapshot_hiv_response"><a href="<?php echo base_url('getsnapshot');?>"><i class="fa fa-backup"></i>View HIV Responses Snapshot</a></li>
                <li id="snapshot_hiv_results"><a href="<?php echo base_url('getHivResults_Snapshot');?>"><i class="fa fa-backup"></i>View HIV Results Snapshot</a></li>
                <li id="view_proposed_tester"><a href="<?php echo base_url('viewProposedTesters');?>"><i class="fa fa-backup"></i>View Proposed Testers</a></li>
                
              </ul>
            </li>
             <li id="viewHIVDTSPending"><a href="<?php echo base_url('addHivSyph') ?>"><i class="fa fa-circle-o"></i>  Data Entry</a></li>
             <li id="viewHIVDTS_samples"><a href="<?php echo base_url('hivdtssamples') ?>"><i class="fa fa-list-alt"></i>  Samples</a></li>
             <li id="viewHIVDTS_results"><a href="<?php echo base_url('hivdtsresults') ?>"><i class="fa fa-tasks" aria-hidden="true"></i>  Results</a></li>
             <li id="viewHIVDTS_distribution"><a href="<?php echo base_url('hivdtsdistribution') ?>"><i class="fa fa-bus" aria-hidden="true"></i> Distribution</a></li>
            

          

          
          
          <!--           use these to create more eqapt sub menus -->

         
          

          <li class="treeview" id="HIVSyphNav">
            <a href="#">
              <i class="fa fa-cube"></i>
              <span>HIV/Syphilis</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              
              <li id="viewHIVDTSOutcome"><a href="<?php echo base_url('') ?>"><i class="fa fa-circle-o"></i> Results</a></li>
             
              <li id="viewHIVDTSPending"><a href="<?php echo base_url('addHivSyph') ?>"><i class="fa fa-circle-o"></i>  First Entry</a></li>
               
              
             
            </ul>
          </li>
            </ul>
          </li>


          <li class="treeview" id="mainUserNav" style="display:none;">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Members</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              
              <li id="createUserNav"><a href="<?php echo base_url('createmember') ?>"><i class="fa fa-circle-o"></i> Add Members</a></li>
             
              <li id="manageUserNav"><a href="<?php echo base_url('Members') ?>"><i class="fa fa-circle-o"></i> Manage Members</a></li>
           
            </ul>
          </li>
        <?php
        }
        elseif ($_SESSION['usercat']=='19'){                  ///Informatics
          ?>

            <li id="dispatchNav">
              <a href="<?php echo base_url('dispatchResult') ?>">
                <i class="fa fa-paper-plane" aria-hidden="true"></i> <span>Dispatch Results</span>
              </a>
            </li>
            <li id="dispatchNav">
              <a href="<?php echo base_url('redispatchResult') ?>">
                <i class="fa fa-paper-plane" aria-hidden="true"></i> <span>Reprint Results</span>
              </a>
            </li>
            <li id="noReturnNav">
              <a href="<?php echo base_url('noDTSreturns') ?>">
                <i class="fa fa-minus-circle" aria-hidden="true"></i> <span>No Returns</span>
              </a>
            </li>
            <li id="view_proposed_tester"><a href="<?php echo base_url('viewProposedTesters');?>"><i class="fa fa-user-md"></i>View Proposed Testers</a></li>
             <li id="viewHIVDTS_samples"><a href="<?php echo base_url('hivdtssamples') ?>"><i class="fa fa-list-alt"></i>  Samples</a></li>
             <li id="viewHIVDTS_results"><a href="<?php echo base_url('hivdtsresults') ?>"><i class="fa fa-tasks" aria-hidden="true"></i> HIV Results</a></li>
             <li id="viewSYPDTS_results"><a href="<?php echo base_url('syphilisdtsresults') ?>"><i class="fa fa-tasks" aria-hidden="true"></i> Syphilis Results</a></li>
             <li id="viewHIVDTS_distribution"><a href="<?php echo base_url('hivdtsdistribution') ?>"><i class="fa fa-bus" aria-hidden="true"></i> Distribution</a></li>
             <li class="treeview" id="dataEntryNav">
              <a href="#">
                <i class="fa fa-cube"></i>
                <span>Data Entry</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                
                <li id="addHivSyph"><a href="<?php echo base_url('addHivSyph') ?>"><i class="fa fa-wpforms"></i> HIV & Syphilis Form</a></li>
                <li id="viewHIVDTS_second_entry"><a href="<?php echo base_url('hiv_second_entry') ?>"><i class="fa fa-circle-o"></i>  Second Entry</a></li>
                <li id="addRecency"><a href="<?php echo base_url('addRecency') ?>"><i class="fa fa-wpforms"></i> HIV Recency </a></li>
                <li id="addCD4"><a href="<?php echo base_url('addCD4') ?>"><i class="fa fa-wpforms"></i> CD4 Entry </a></li>
              </ul>
            </li>

            <li class="treeview" id="settingsNav">
              <a href="#">
                <i class="fa fa-gears"></i>
                <span>Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu separator">
                
                <li id="manageFacility"><a href="<?php echo base_url('manageFacility') ?>"><i class="fa fa-institution"></i> Facilities</a></li>
                <li id="manageTester"><a href="<?php echo base_url('manageTester') ?>"><i class="fa fa-users"></i>  Testers</a></li>
                <li id="manageHub"><a href="<?php echo base_url('manageHub') ?>"><i class="fa fa-github-square"></i>  Hubs</a></li>
               <li id="manageCycle"><a href="<?php echo base_url('manageCycle') ?>"><i class="fa fa-arrow-circle-o-down"></i>  Cycles</a></li>
                <li id="manageRegion"><a href="<?php echo base_url('manageRegion') ?>"><i class="fa fa-hospital-o"></i>  Regions</a></li>
                <li id="manageDistrict"><a href="<?php echo base_url('manageDistrict') ?>"><i class="fa fa-y-combinator"></i>  Districts</a></li>
                <li id="manageCadre"><a href="<?php echo base_url('manageCadre') ?>"><i class="fa fa-user-md"></i>Title</a></li>
                <li id="manageTileCategory"><a href="<?php echo base_url('manageTitleCategory') ?>"><i class="fa fa-user-md"></i>Title Category</a></li>
              </ul>
            </li>
           
          <?php
        }
        elseif($_SESSION['usercat']=='6' || $_SESSION['usercat']=='10'){                    ///Data Manager + Mbidde
          ?>
          <li class="treeview" id="dataEntryNav">
              <a href="#">
                <i class="fa fa-cube"></i>
                <span>Data Entry</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                
                <li id="addHivSyph"><a href="<?php echo base_url('addHivSyph') ?>"><i class="fa fa-wpforms"></i> HIV & Syphilis Form</a></li>
                <li id="addRecency"><a href="<?php echo base_url('addRecency') ?>"><i class="fa fa-wpforms"></i> HIV Recency </a></li>
               
              </ul>
            </li>
            
            <li id="viewHIVDTS_samples"><a href="<?php echo base_url('hivdtssamples') ?>"><i class="fa fa-list-alt"></i>  HIV Samples</a></li>
            <li id="viewHIVDTS_results"><a href="<?php echo base_url('hivdtsresults') ?>"><i class="fa fa-tasks" aria-hidden="true"></i>  HIV Results</a></li>
             <li id="viewSYPH_samples"><a href="<?php echo base_url('syphilisSamples') ?>"><i class="fa fa-list-alt"></i>  Syphilis Samples</a></li>
            <li id="viewHIVREC_samples"><a href="<?php echo base_url('hivrecencysamples') ?>"><i class="fa fa-list-alt"></i>  Recency Samples</a></li>

            
            <li id="viewHIVDTS_distribution"><a href="<?php echo base_url('hivdtsdistribution') ?>"><i class="fa fa-bus" aria-hidden="true"></i> Distribution</a></li>
            <li id="view_proposed_tester"><a href="<?php echo base_url('viewProposedTesters');?>"><i class="fa fa-user-md"></i>View Proposed Testers</a></li>

            <li class="treeview" id="settingsNav">
              <a href="#">
                <i class="fa fa-gears"></i>
                <span>Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu separator">
                
                <li id="manageFacility"><a href="<?php echo base_url('manageFacility') ?>"><i class="fa fa-institution"></i> Facilities</a></li>
                <li id="manageTester"><a href="<?php echo base_url('manageTester') ?>"><i class="fa fa-users"></i>  Testers</a></li>
                <li id="manageHub"><a href="<?php echo base_url('manageHub') ?>"><i class="fa fa-github-square"></i>  Hubs</a></li>
               <li id="manageCycle"><a href="<?php echo base_url('manageCycle') ?>"><i class="fa fa-arrow-circle-o-down"></i>  Cycles</a></li>
                <li id="manageRegion"><a href="<?php echo base_url('manageRegion') ?>"><i class="fa fa-hospital-o"></i>  Regions</a></li>
                <li id="manageDistrict"><a href="<?php echo base_url('manageDistrict') ?>"><i class="fa fa-y-combinator"></i>  Districts</a></li>
                <li id="manageCadre"><a href="<?php echo base_url('manageCadre') ?>"><i class="fa fa-user-md"></i>Title</a></li>
                <li id="manageTileCategory"><a href="<?php echo base_url('manageTitleCategory') ?>"><i class="fa fa-user-md"></i>Title Category</a></li>
                <li id="snapshot_hiv_response"><a href="<?php echo base_url('getsnapshot');?>"><i class="fa fa-backup"></i>View HIV Responses Snapshot</a></li>
                <li id="snapshot_hiv_results"><a href="<?php echo base_url('getHivResults_Snapshot');?>"><i class="fa fa-backup"></i>View HIV Results Snapshot</a></li>
                
              </ul>
            </li>
          <?php
        }
        elseif($_SESSION['usercat']=='2'){                    ///Lab Technologist
          ?>
            <li id="dispatchNav">
              <a href="<?php echo base_url('dispatchResult') ?>">
                <i class="fa fa-paper-plane" aria-hidden="true"></i> <span>Review Results</span>
              </a>
            </li>
            <li id="dispatchNav">
              <a href="<?php echo base_url('redispatchResult') ?>">
                <i class="fa fa-paper-plane" aria-hidden="true"></i> <span>Reprint Results</span>
              </a>
            </li>
           <li id="viewHIVDTS_samples"><a href="<?php echo base_url('hivdtssamples') ?>"><i class="fa fa-list-alt" aria-hidden="true"></i>  Samples</a></li>
           <li id="viewHIVDTS_results"><a href="<?php echo base_url('hivdtsresults') ?>"><i class="fa fa-tasks" aria-hidden="true"></i> HIV Results</a></li>
           <li id="viewSYPDTS_results"><a href="<?php echo base_url('syphilisdtsresults') ?>"><i class="fa fa-tasks" aria-hidden="true"></i> Syphilis Results</a></li>
           <li id="releaseHIVDTS_entry"><a href="<?php echo base_url('release_dts_entry') ?>"><i class="fa fa-circle-o"></i> Release Entries</a></li>
           <li id="viewHIVREC_samples"><a href="<?php echo base_url('hivrecencysamples') ?>"><i class="fa fa-list-alt"></i>  Recency Samples</a></li>

           <li class="treeview" id="settingsNav">
              <a href="#">
                <i class="fa fa-gears"></i>
                <span>Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu separator">
                
                <li id="manageFacility"><a href="<?php echo base_url('manageFacility') ?>"><i class="fa fa-institution"></i> Facilities</a></li>
                <li id="manageTester"><a href="<?php echo base_url('manageTester') ?>"><i class="fa fa-users"></i>  Testers</a></li>
                <li id="manageHub"><a href="<?php echo base_url('manageHub') ?>"><i class="fa fa-github-square"></i>  Hubs</a></li>
               <li id="manageCycle"><a href="<?php echo base_url('manageCycle') ?>"><i class="fa fa-arrow-circle-o-down"></i>  Cycles</a></li>
                <li id="manageRegion"><a href="<?php echo base_url('manageRegion') ?>"><i class="fa fa-hospital-o"></i>  Regions</a></li>
                <li id="manageDistrict"><a href="<?php echo base_url('manageDistrict') ?>"><i class="fa fa-y-combinator"></i>  Districts</a></li>
                <li id="manageCadre"><a href="<?php echo base_url('manageCadre') ?>"><i class="fa fa-user-md"></i>Title</a></li>
                <li id="manageTileCategory"><a href="<?php echo base_url('manageTitleCategory') ?>"><i class="fa fa-user-md"></i>Title Category</a></li>
              </ul>
            </li>
          <?php
        }
        elseif($_SESSION['usercat']=='3'){                    ///Data Entry Team
          ?>
          <li class="treeview" id="dataEntryNav">
              <a href="#">
                <i class="fa fa-cube"></i>
                <span>Data Entry</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                
                <li id="addHivSyph"><a href="<?php echo base_url('addHivSyph') ?>"><i class="fa fa-wpforms"></i> HIV & Syphilis Form</a></li>
                <li id="addRecency"><a href="<?php echo base_url('addRecency') ?>"><i class="fa fa-wpforms"></i> HIV Recency </a></li>
                
              </ul>
            </li>
            
            <li id="viewHIVDTS_samples"><a href="<?php echo base_url('hivdtssamples') ?>"><i class="fa fa-list-alt"></i>  Samples</a></li>
            <li id="viewHIVDTS_results"><a href="<?php echo base_url('hivdtsresults') ?>"><i class="fa fa-tasks" aria-hidden="true"></i>  Results</a></li>
            
            <li class="treeview" id="settingsNav">
              <a href="#">
                <i class="fa fa-gears"></i>
                <span>Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu separator">
                
                <li id="manageFacility"><a href="<?php echo base_url('manageFacility') ?>"><i class="fa fa-institution"></i> Facilities</a></li>
                <li id="manageTester"><a href="<?php echo base_url('manageTester') ?>"><i class="fa fa-users"></i>  Testers</a></li>
                <li id="manageHub"><a href="<?php echo base_url('manageHub') ?>"><i class="fa fa-github-square"></i>  Hubs</a></li>
               <li id="manageCycle"><a href="<?php echo base_url('manageCycle') ?>"><i class="fa fa-arrow-circle-o-down"></i>  Cycles</a></li>
                <li id="manageRegion"><a href="<?php echo base_url('manageRegion') ?>"><i class="fa fa-hospital-o"></i>  Regions</a></li>
                <li id="manageDistrict"><a href="<?php echo base_url('manageDistrict') ?>"><i class="fa fa-y-combinator"></i>  Districts</a></li>
                <li id="manageCadre"><a href="<?php echo base_url('manageCadre') ?>"><i class="fa fa-user-md"></i>Title</a></li>
                <li id="manageTileCategory"><a href="<?php echo base_url('manageTitleCategory') ?>"><i class="fa fa-user-md"></i>Title Category</a></li>
              </ul>
            </li>
          <?php        }
        elseif($_SESSION['usercat']=='4'){                    ///Monitoring and Evaluationt
          ?>
          <li id="storeNav">
              <a href="<?php echo base_url('dashboard') ?>">
                <i class="fa fa-institution"></i> <span>Monitoring & Evaluation </span>
              </a>
            </li>
            <li id="viewHIVDTS_samples"><a href="<?php echo base_url('hivdtssamples') ?>"><i class="fa fa-list-alt"></i>  Samples</a></li>
            <li id="viewHIVDTS_results"><a href="<?php echo base_url('hivdtsresults') ?>"><i class="fa fa-tasks" aria-hidden="true"></i> HIV Results</a></li>
            <li id="viewSYPDTS_results"><a href="<?php echo base_url('syphilisdtsresults') ?>"><i class="fa fa-tasks" aria-hidden="true"></i> Syphilis Results</a></li>

            
             <li id="dispatchNav">
              <a href="<?php echo base_url('dispatchResult') ?>">
                <i class="fa fa-paper-plane" aria-hidden="true"></i> <span>Review Results</span>
              </a>
            </li>
            <li class="treeview" id="settingsNav">
              <a href="#">
                <i class="fa fa-gears"></i>
                <span>Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu separator">
                
                <li id="manageFacility"><a href="<?php echo base_url('manageFacility') ?>"><i class="fa fa-institution"></i> Facilities</a></li>
                <li id="manageTester"><a href="<?php echo base_url('manageTester') ?>"><i class="fa fa-users"></i>  Testers</a></li>
                 <li id="viewHIVDTS_distribution"><a href="<?php echo base_url('hivdtsdistribution') ?>"><i class="fa fa-bus" aria-hidden="true"></i> Distribution</a></li>
                <li id="manageHub"><a href="<?php echo base_url('manageHub') ?>"><i class="fa fa-github-square"></i>  Hubs</a></li>
               <li id="manageCycle"><a href="<?php echo base_url('manageCycle') ?>"><i class="fa fa-arrow-circle-o-down"></i>  Cycles</a></li>
                <li id="manageRegion"><a href="<?php echo base_url('manageRegion') ?>"><i class="fa fa-hospital-o"></i>  Regions</a></li>
                <li id="manageDistrict"><a href="<?php echo base_url('manageDistrict') ?>"><i class="fa fa-y-combinator"></i>  Districts</a></li>
                <li id="manageCadre"><a href="<?php echo base_url('manageCadre') ?>"><i class="fa fa-user-md"></i>Title</a></li>
                <li id="manageTileCategory"><a href="<?php echo base_url('manageTitleCategory') ?>"><i class="fa fa-user-md"></i>Title Category</a></li>
              </ul>
            </li>
          <?php
        }
        elseif($_SESSION['usercat']=='5'){                    ///Quality Assurance / Quality Control
          ?>
          <li id="storeNav">
              <a href="<?php echo base_url('Warehouse/') ?>">
                <i class="fa fa-institution"></i> <span>QA/QC Menus</span>
              </a>
            </li>
            <li id="viewHIVDTS_samples"><a href="<?php echo base_url('hivdtssamples') ?>"><i class="fa fa-list-alt"></i> Samples</a></li>
            <li class="treeview" id="settingsNav">
              <a href="#">
                <i class="fa fa-gears"></i>
                <span>Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu separator">
                
                <li id="manageFacility"><a href="<?php echo base_url('manageFacility') ?>"><i class="fa fa-institution"></i> Facilities</a></li>
                <li id="manageTester"><a href="<?php echo base_url('manageTester') ?>"><i class="fa fa-users"></i>  Testers</a></li>
                <li id="manageHub"><a href="<?php echo base_url('manageHub') ?>"><i class="fa fa-github-square"></i>  Hubs</a></li>
               <li id="manageCycle"><a href="<?php echo base_url('manageCycle') ?>"><i class="fa fa-arrow-circle-o-down"></i>  Cycles</a></li>
                <li id="manageRegion"><a href="<?php echo base_url('manageRegion') ?>"><i class="fa fa-hospital-o"></i>  Regions</a></li>
                <li id="manageDistrict"><a href="<?php echo base_url('manageDistrict') ?>"><i class="fa fa-y-combinator"></i>  Districts</a></li>
                <li id="manageCadre"><a href="<?php echo base_url('manageCadre') ?>"><i class="fa fa-user-md"></i>Title</a></li>
                <li id="manageTileCategory"><a href="<?php echo base_url('manageTitleCategory') ?>"><i class="fa fa-user-md"></i>Title Category</a></li>
              </ul>
            </li>
          <?php
        }
        
        elseif($_SESSION['usercat']=='11'){                   ///DLFP 
          ?>
         
              <li id="manageFacility"><a href="<?php echo base_url('manageFacility') ?>"><i class="fa fa-institution"></i> Facilities</a></li>
              <li id="manageTester"><a href="<?php echo base_url('manageTester') ?>"><i class="fa fa-users"></i>  Testers</a></li>

              <li id="viewHIVDTS_distribution"><a href="<?php echo base_url('hivdtsdistribution') ?>"><i class="fa fa-bus" aria-hidden="true"></i> Distribution</a></li>
              <li id="viewHIVDTS_samples"><a href="<?php echo base_url('hivdtssamples') ?>"><i class="fa fa-list-alt"></i>  Samples</a></li>
              <li id="viewHIVDTSOutcome"><a href="<?php echo base_url('') ?>"><i class="fa fa-circle-o"></i> Results</a></li>

             
            
          <?php
        }
        


        ?>
            
          
            

        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-power-off"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    
    <!-- /.sidebar -->
  </aside>
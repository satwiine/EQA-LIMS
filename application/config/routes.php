<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route['Members']			 				= 'manage/viewUsers';
$route['createmember']		 				= 'manage/addUser';
$route['savemember']		 				= 'manage/createUser';
$route['dashboard']			 				= 'manage/dashboard';
$route['ItemCategory']		 				= 'manage/itemcategory';
$route['CreateCategory'] 					= 'manage/createItemCategory';
$route['fetchCategoryData']	 				= 'manage/fetchCategoryData';
$route['fetchCategoryDataById/(:any)']		= 'manage/fetchCategoryDataById/$1';
$route['UpdateCategory/(:any)']				= 'manage/updateCategory/$1';
$route['removeCategory/(:any)']				= 'manage/removeCategory/$1';
$route['Warehouse']							= 'manage/Warehouse';
$route['getWarehouseData']					= 'manage/fetchWarehouseData';


$route['viewProposedTesters']				= 'manage/proposedTester';
$route['fetchproposedTester']				= 'manage/fetchproposedTester';
$route['saveProposedTester/(:any)']			= 'manage/saveProposedTester/$1';
$route['removeProposedTester/(:any)']		= 'manage/removeProposedTester/$1';

$route['manageFacility']					= 'manage/getFacility';
$route['fetchFacility']						= 'manage/fetchFacility';
$route['delFacility/(:any)']				= 'manage/deactivetFacility/$1';
$route['activateFacility/(:any)']			= 'manage/reactivateFacility/$1';
$route['manageDistrict']					= 'manage/getDistrict';
$route['fetchDistrict']						= 'manage/fetchDistrict';
$route['manageRegion']						= 'manage/getRegion';
$route['viewRegionDetail/(:any)']			= 'manage/fetchRegionDetail/$1';
$route['fetchRegion']						= 'manage/fetchRegion';
$route['createRequest']						= 'manage/createRequest';
$route['requestItem']						= 'manage/addRequest';
$route['addTester']							= 'manage/addTester';
$route['saveTester']						= 'manage/saveNewTester';
$route['updateTester']						= 'manage/updateTester';
$route['removeTester/(:any)']				= 'manage/removeTester/$1';
$route['reactivateTester/(:any)']			= 'manage/reactivateTester/$1';

$route['addFacility']						= 'manage/addFacility';
$route['saveFacility']						= 'manage/saveFacility';
$route['editFacility/(:any)']				= 'manage/editFacility/$1';
$route['updateFacility']					= 'manage/updateFacility';

$route['manageHub']							= 'manage/getHub';
$route['fetchHub']							= 'manage/fetchHub';
$route['createCycle']						= 'manage/createCycle';
$route['manageCycle']						= 'manage/getCycle';
$route['fetchCycle']						= 'manage/fetchCycle';
$route['savenewcycle']						= 'manage/SaveDtsCycle';
$route['cycleDetail/(:any)']				= 'manage/getcycleDetail/$1';
$route['saveCycleResults']					= 'manage/saveHIVSypExpectedResults';

$route['recDispatch']						= 'manage/RecencyDispatch';
$route['fetchrecDispatch']					= 'manage/fetchRecDispatch';
$route['dispatchResult']					= 'manage/resultDispatch';
$route['fetchDispatch']						= 'manage/fetchDispatch';

$route['redispatchResult']					= 'manage/reDispatch';
$route['fetchreDispatch']					= 'manage/fetchReDispatch';

$route['printdtsSample/(:any)']				= 'manage/printdtsSample/$1';
$route['loadPdfReport/(:any)']				= 'manage/loadPdfReport/$1';
$route['printrecSample/(:any)']				= 'manage/printrecSample/$1';
$route['viewDtsSample/(:any)']				= 'manage/reviewdtsSample/$1';

$route['manageTitleCategory']				= 'manage/getTitleCategory';
$route['fetchTitleCategory']				= 'manage/fetchTitleCategory';
$route['fetchTitle']						= 'manage/fetchTitle';
$route['saveTitle']							= 'manage/createTitle';
$route['addTitle']							= 'manage/addTitle';

$route['manageCadre']						= 'manage/getTitle';
$route['manageTester']						= 'manage/getTester';
$route['fetchTester']						= 'manage/fetchTester';
$route['testerDetail/(:any)']				= 'manage/getTesterDetail/$1';
$route['editTester/(:any)']					= 'manage/editTester/$1';
$route['getDoD/(:any)/(:any)/(:any)/(:any)']= 'manage/fetchDoDBySiteCycle/$1/$2/$3/$4';


$route['updateDashboard']					= 'manage/UpdateDashboard';
$route['updateDts']							= 'manage/updateDtsRecord';
$route['addHivSyph']						= 'manage/dtsDataentry';
$route['saveDts']							= 'manage/addDtsRecord';
$route['hiv_second_entry']					= 'manage/getHivDtsSecondEntrySamples';
$route['hivdtssamples']						= 'manage/hivdtssamplelist';
$route['addRecency']						= 'manage/recencyDataentry';
$route['saveRecency']						= 'manage/addRecencyRecord';
$route['release_dts_entry']					= 'manage/Release_Entries';
$route['hivrecencysamples']					= 'manage/hivrecencysampleList';
$route['fetchRecencySamples']				= 'manage/fetchRecencySampleList';
$route['editdtsEntry/(:any)']				= 'manage/editDtsEntry/$1';

$route['syphilisSamples']					= 'manage/syphilisSampleList';
$route['fetchSyphilisSamples']				= 'manage/fetchSyphilisSamples';

$route['approveRecencyResult/(:any)']		= 'manage/approveRecResult/$1';

$route['fetchSecondEntries']				= 'manage/fetchHIVSamples';
$route['viewdtsEntry/(:any)']				= 'manage/showDtsEntry/$1';
$route['dtsSecondEntry/(:any)']				= 'manage/dtsSecondEntry/$1';
$route['approveDtsResult/(:any)']			= 'manage/dtsResultApproval/$1';
$route['approvedts']						= 'manage/approveDtsForm';
$route['recalldtsApproval/(:any)']			= 'manage/recallHIVDtsApproval/$1';
$route['reports']							= 'manage/reporting';


$route['hivdrdashboard']					= 'manage/getDrPendingResults';
$route['fetchUnresultedSample']				= 'manage/fetchUnresultedSamples';
$route['getDRJsonResult']					= 'manage/getDRjsonResult';
$route['fetchDRJsonFile']					= 'manage/getDRJsonFile';
$route['insert_dr_data']					= 'manage/createDrRecord';
$route['getDrResultsToSend']				= 'manage/getPendingDRUpload';
$route['fetchDrPendingUpload']				= 'manage/fetchUnUploadedResult';
$route['drSendResult/(:any)']				= 'manage/drUploadResult/$1';
$route['drSendUnAmplified/(:any)']			= 'manage/drUploadUnAmplified/$1';




$route['importDistro']						= 'manage/importDistribution';


$route['getsnapshot']						= 'manage/listSnapshotData';
$route['getHivResults_Snapshot']			= 'manage/listHivResults_snapshot';

$route['fetchresponsesnapshot']				= 'manage/getHIVSnapshotData';
$route['fetchhivresultsnapshot']			= 'manage/getHIVResults_Sanpshot';




$route['hivdtsdistribution']				= 'manage/listDistributions';
$route['fetchDistribution']					= 'manage/getDistributions';
$route['viewDistroDetail/(:any)/(:any)']	= 'manage/listDistroDetail/$1/$2';
$route['fetchDistroDetail/(:any)/(:any)']	= 'manage/fetchDistributionByFacilityCycle/$1/$2';
$route['hivdtsresults']						= 'manage/listResults';
$route['fetchdtsResults']					= 'manage/getdtsResults';

$route['syphilisdtsresults']				= 'manage/listsyphResults';
$route['fetchResultsWithComments']			= 'manage/fetchResultsWithComments';
$route['fetchsypResultsWithComments']		= 'manage/fetchsypResultsWithComments';
$route['addcycleresult']					= 'manage/addCycleResult';
$route['fetchscrTestResult']				= 'manage/getTestResults_sec1';
$route['getTestResult']						= 'manage/getTestResult';



$route['default_controller']				 				= 'auth/login';

$route['404_override'] 						= '';
$route['translate_uri_dashes']	 			= FALSE;

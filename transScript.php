<?php
// Title: transScript.php 

// Class to get all the SQL for the queries
class Queries{

    // returns the query for the Cumulative College Breakdown Report
    public static function getSumColRpt(){return file_get_contents('queries/cumulativecollegerpt.txt');}

    // returns the query for getting the course history from VolState
    public static function getVSClasses(){return file_get_contents('queries/vsclasses.txt');}

    // returns the query for getting the course history from Penn State
    public static function getPSUClasses(){return file_get_contents('queries/psuclasses.txt');}

    // returns the query for getting student information from VolState
    public static function getVSInfo(){return file_get_contents('queries/vsinfo.txt');}

    // returns the query for getting student information from Penn State
    public static function getPSUInfo(){return file_get_contents('queries/psuinfo.txt');}

    // returns the query for the credit breakdown
    public static function getCreditBreakdown(){return file_get_contents('queries/creditbreakdown.txt');}

} // End [Class : Queries]

// Class to perform SQLite3 Connection
class getConnection{

    // returns a SQLite3 database object directed at the data source in the tree
    public static function sqliteConnection(){return new SQLite3('data/coursehistory.db');}

} // End [Class : getConnection]

// Class to build all the HTML Documents
class pageBuilder{

    // builds an HTML Cumulative College Report Document
    public static function buildCumColRpt($dataobject, $query){
        $report_data = $dataobject->query($query);
        $report_raw = $report_data->fetchArray();
        $totalcreds = $report_raw["Total Credits"];
        $col1 = $report_raw["College [1]"];
        $deg1 = $report_raw["Degree [1]"];
        $maj1 = $report_raw["Major [1]"];
        $gpa1 =  $report_raw["GPA [1]"];
        $col2 =  $report_raw["College [2]"];
        $deg2 =  $report_raw["Degree [2]"];
        $maj2 =  $report_raw["Major [2]"];
        $gpa2 =  $report_raw["GPA [2]"];
        $report = new DOMDocument();
        $html = "<head><title>Cumulative College Report</title></head><center><strong>Cumulative College Report</strong></center><br><br><table style='width:100%'><tr><th>Total Credits</th><th>College [1]</th><th>Degree [1]</th><th>Major [1]</th><th>GPA [1]</th><th>College [2]</th><th>Degree [2]</th><th>Major [2]</th><th>GPA [2]</th></tr><hr><tr><td>$totalcreds</td><td>$col1</td><td>$deg1</td><td>$maj1</td><td>$gpa1</td><td>$col2</td><td>$maj2</td><td>$deg2</td><td>$gpa2</td></tr></table>";
        @$report->loadHTML($html);
        $report->saveHTMLFile('sysgens/cumColRpt.html');

    }

    // builds an HTML Class history report for VolState
    public static function buildVSClassRpt($dataobject, $query){
        $list_data = $dataobject->query($query);
        $table = new DOMDocument();
        $html = "<head><title>VolState Community College Course List</title></head><center><strong>Volunteer State Community College Course History</strong></center><br><br><table style='width:100%'><tr><th>Course</th><th>Catalog ID</th><th>Course Title</th><th>Credit Units</th><th>Course Term</th><th>Course Grade</th></tr><hr>";
        while ($row = $list_data->fetchArray()) {
            $html .= "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td></tr>";
        }
        @$table->loadHTML($html);
        $table->saveHTMLFile('sysgens/VSClasses.html');
    }

    // builds an HTML Class history report for Penn State
    public static function buildPSUClassRpt($dataobject, $query){
        $list_data = $dataobject->query($query);
        $table = new DOMDocument();
        $html = "<head><title>Penn State University Course List</title></head><center><strong>Pennsylvania State University Course History</strong></center><br><br><table style='width:100%'><tr><th>Course</th><th>Catalog ID</th><th>Course Title</th><th>Credit Units</th><th>Course Term</th><th>Course Grade</th></tr><hr>";
        while ($row = $list_data->fetchArray()) {
            $html .= "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td></tr>";
        }
        @$table->loadHTML($html);
        $table->saveHTMLFile('sysgens/PSUClasses.html');
    }

    // builds an HTML Information Report for VolState
    public static function buildVSInfoRpt($dataobject, $query){
        $report_data = $dataobject->query($query);
        $report_raw = $report_data->fetchArray();
        $school = $report_raw[0];
        $id = $report_raw[1];
        $gpa = $report_raw[2];
        $deg = $report_raw[3];
        $dep = $report_raw[4];
        $maj = $report_raw[5];
        $html = "<head><title>VolState Community College Information</title></head><center><strong>Volunteer State Community College Information</strong></center><br><br><table style='width:100%'><tr><th>College</th><th>College ID</th><th>Overall GPA</th><th>Degree</th><th>Department</th><th>Major</th></tr><hr><tr><td>$school</td><td>$id</td><td>$gpa</td><td>$deg</td><td>$dep</td><td>$maj</td></tr></table>";
        $report = new DOMDocument();
        @$report->loadHTML($html);
        $report->saveHTMLFile('sysgens/VSInfo.html');
    }

    // builds an HTML Information Report for VolState
    public static function buildPSUInfoRpt($dataobject, $query){
        $report_data = $dataobject->query($query);
        $report_raw = $report_data->fetchArray();
        $school = $report_raw[0];
        $id = $report_raw[1];
        $gpa = $report_raw[2];
        $deg = $report_raw[3];
        $dep = $report_raw[4];
        $maj = $report_raw[5];
        $html = "<head><title>Penn State University Information</title></head><center><strong>Pennsylvania State University Information</strong></center><br><br><table style='width:100%'><tr><th>College</th><th>College ID</th><th>Overall GPA</th><th>Degree</th><th>Department</th><th>Major</th></tr><hr><tr><td>$school</td><td>$id</td><td>$gpa</td><td>$deg</td><td>$dep</td><td>$maj</td></tr></table>";
        $report = new DOMDocument();
        @$report->loadHTML($html);
        $report->saveHTMLFile('sysgens/PSUInfo.html');
    }

    // builds and HTML Credit Breakdown Report
    public static function buildCreditBreakdownRpt($dataobject, $query){
        $breakdown_data = $dataobject->query($query);
        $breakdown_raw = $breakdown_data->fetchArray();
        $vscredits = $breakdown_raw[0];
        $psucredits = $breakdown_raw[1];
        $transcredits = $breakdown_raw[2];
        $transto = $breakdown_raw[3];
        $transfrom = $breakdown_raw[4];
        $html = "<head><title>Credit Breakdown</title></head><center><strong>Credit Breakdown Report</strong></center><br><br><table style='width:100%'><tr><th>Credit Count :: VolState</th><th>Credit Count :: Penn State</th><th>Credit Count :: Transfer</th><th>Transferred To:</th><th>Transferred From:</th></tr><hr><tr><td>$vscredits</td><td>$psucredits</td><td>$transcredits</td><td>$transto</td><td>$transfrom</td></tr></table>";
        $report = new DOMDocument();
        @$report->loadHTML($html);
        $report->saveHTMLFile('sysgens/CredBreakdownRpt.html');
    }

} // End [Class : pageBuilder]

// returns an array with all SQL queries
function fetch_query_array(){
    $queryAccessor = new Queries();
    $cumColRptquery = $queryAccessor::getSumColRpt();
    $VSClassesquery = $queryAccessor::getVSClasses();
    $PSUClassesquery = $queryAccessor::getPSUClasses();
    $VSInfoquery = $queryAccessor::getVSInfo();
    $PSUInfoquery = $queryAccessor::getPSUInfo();
    $creditBreakdownquery = $queryAccessor::getCreditBreakdown();
    return array(
        $cumColRptquery,
        $VSClassesquery,
        $PSUClassesquery,
        $VSInfoquery,
        $PSUInfoquery,
        $creditBreakdownquery
    );
}

// Parses all the queries and constructs them using pageBuilder @params = {[Database Object], [Query Array]}
function buildPages($dataobject, $query_list){
    $builder = new pageBuilder();
    $queryCOLRPT = $query_list[0];
    $queryVSCls = $query_list[1];
    $queryPSUCls = $query_list[2];
    $queryVSInf = $query_list[3];
    $queryPSUInf = $query_list[4];
    $queryCrdBrk = $query_list[5];
    $builder::buildCumColRpt($dataobject, $queryCOLRPT);
    $builder::buildVSClassRpt($dataobject, $queryVSCls);
    $builder::buildPSUClassRpt($dataobject, $queryPSUCls);
    $builder::buildVSInfoRpt($dataobject, $queryVSInf);
    $builder::buildPSUInfoRpt($dataobject, $queryPSUInf);
    $builder::buildCreditBreakdownRpt($dataobject, $queryCrdBrk);
}

// Imperative Start Point
$dataobject = getConnection::sqliteConnection();
$query_list = fetch_query_array();
buildPages($dataobject, $query_list);

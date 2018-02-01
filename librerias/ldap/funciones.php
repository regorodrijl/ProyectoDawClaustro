<?php 


public function getProfes(){
    //config
    $ldapserver = '193.144.43.241';
    $ldapuser      = 'adminweb';  
    $ldappass     = 'ciscoabc123-.,';
    $ldaptree    = 'OU=Profes,OU=SC-Usuarios,DC=sanclemente,DC=local';

    $ldapconn = ldap_connect($ldapserver,'65500') or die("Could not connect to LDAP server.");

    if($ldapconn) {
        // binding to ldap server
        $ldapbind = ldap_bind($ldapconn, $ldapuser, $ldappass) or die ("Error trying to bind: ".ldap_error($ldapconn));
         // verify binding
        if ($ldapbind) {
            $result = ldap_search($ldapconn,$ldaptree, "(cn=*)") or die ("Error in search query: ".ldap_error($ldapconn));
            $data = ldap_get_entries($ldapconn, $result);
            print_r($data);
            // iterate over array and print data for each entry
            echo '<h1>Show me the users</h1>';
            
            for ($i=0; $i<$data["count"]; $i++) {
            //echo "dn is: ". $data[$i]["dn"] ."<br />";
                echo "User: ". $data[$i]["cn"][0] ."<br />";
                if(isset($data[$i]["mail"][0])) {
                    echo "Email: ". $data[$i]["mail"][0] ."<br /><br />";
                } else {
                    echo "Email: None<br /><br />";
                }
            }
        // print number of entries found
            echo "Number of entries found: " . ldap_count_entries($ldapconn, $result);
        } else {
            echo "LDAP bind failed...";
        }

    }

    // all done? clean up
    ldap_close($ldapconn);
}

?>
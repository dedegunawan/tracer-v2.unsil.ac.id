<?php
/**
 *
 */
class Role
{

    function __construct()
    {
        # code...
    }
    function roleByLevelID($LevelID) {
        $allRole = $this->allRole();
        $defaultRole = '--';
        if (!in_array($LevelID, array_keys($allRole))) {
            $LevelID = $defaultRole;
        }
        return @$allRole[$LevelID];
    }
    function allRole() {
        return array(
                '1' => array('Dashboard', 'MasterAlumni', 'MasterPengguna', 'AnalisaAlumni', 'AnalisaPengguna', 'SaranAlumni', 'SaranPengguna'),
                '27' => array('Dashboard', 'MasterAlumni', 'MasterPengguna', 'AnalisaAlumni', 'AnalisaPengguna', 'SaranAlumni', 'SaranPengguna'),
                '--' => array('Dashboard', 'AnalisaAlumni', 'AnalisaPengguna', 'SaranAlumni', 'SaranPengguna'),
        );
    }
    function hasAccess($roleName) {
        $LevelID = @$_SESSION['userInfo']->LevelID;
        $role = $this->roleByLevelID($LevelID);
        if (in_array($roleName, $role)) {
            return true;
        }
        else {
            return false;
        }
    }
    function hasAccessWithRedirect($roleName) {
        if (!$this->hasAccess($roleName)) {
            $this->redirectTo403();
        }
    }
    function redirectTo403() {
        redirect(base_url('errors/e403'));
    }
}

?>

<?php
$user_session = $this->session->userdata('user_session');
$row = $this->Modules->users_list($user_session);
$data = $row->result();
foreach ($data as $key) {
    $name = $key->fname . " " . $key->lastname;
    $email = $key->email . " " . $key->email;
}
?>
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="user-wrapper">
                    <div class="profile-image">
                        <img src="<?php if (isset($_SESSION['profile_pic'])) {
    echo $_SESSION['profile_pic'];
} else {
    echo site_url("images/profile.png");
} ?>"  alt="profile image">
                    </div>
                    <div class="text-wrapper">
                        <p class="profile-name"><?php if (isset($_SESSION['name'])) {
    echo $_SESSION['name'];
} else {
    echo $name;
} ?></p>
                        <div>
                            <small class="designation text-muted"><?php if (isset($_SESSION['email'])) {
    echo $_SESSION['email'];
} else {
    echo $email;
} ?></small>
                            <span class="status-indicator online"></span>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success btn-block" onClick="window.location.reload()">Refresh
                    <i class="mdi mdi-refresh"></i>
                </button>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo site_url(); ?>">
                <i class="menu-icon mdi mdi-television"></i>
                <span class="menu-title">Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="menu-icon mdi mdi-format-list-numbers"></i>
                <span class="menu-title">My Company</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <?php
                    $row = $this->Modules->client_group($user_session);
                    $data = $row->result();
                    foreach ($data as $key) {
                        ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url("Company/id/" . $key->ID); ?>"><?php echo $key->account; ?></a>
                        </li>
    <?php
}
?>
                </ul>
            </div>
        </li>


    </ul>
</nav>
<!-- partial -->

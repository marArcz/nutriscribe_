<div id="sidebar" class="sidebar bg-green-accent shadow <?= Session::hasSession("closed_sidebar") ? 'closed':'' ?>">
    <div class="sidebar-header bg-green-accent ">
        <a class=" d-flex py-2 link-light justify-content-center align-items-center text-decoration-none" href="#">
            <img src="../../assets/images/logo.png" width="40" alt="">
            <small class="ms-2 fw-bold title"><?= $_ENV['APP_NAME'] ?></small>
        </a>
    </div>
    <ul class="nav mt-1">
        <?php
        $navItems = [
            'Dashboard' => [
                'link' => 'dashboard.php',
                'key' => 'dashboard',
                'icon'=>'bx bxs-dashboard'
            ],
            'BN Scholars' => [
                'link' => 'scholars.php',
                'key' => 'scholars',
                'icon'=>'bx bxs-user'
            ],
            'Attendance Record' => [
                'link' => 'attendance.php',
                'key' => 'attendance',
                'icon'=>'bx bxs-book'
            ],
            'BN Scholar Activities' => [
                'link' => 'scholar_activities.php',
                'key' => 'scholar_activities',
                'icon'=>'bx bxs-note'
            ],
           
        ];
        ?>
        <?php foreach ($navItems as $name => $navItem) : ?>
            <li class="nav-item mb-3 <?= $current_page == $navItem['key'] ? 'active' : '' ?>">
                <a href="<?= $navItem['link'] ?>" class="nav-link link-light d-flex align-items-center">
                    <i class="fs-6 my-0 <?= $navItem['icon'] ?>"></i>
                    <span><?= $name ?></span>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>

<div class="sidebar-overlay-sm <?= Session::hasSession("closed_sidebar")?'show':'' ?>" id="sidebar-overlay"></div>
<div id="sidebar" class="sidebar shadow closed">
    <div class="sidebar-header bg-transparent ">
        
    </div>
    <ul class="nav mt-1">
        <?php
        $navItems = [
            'Home' => [
                'link' => 'home.php',
                'key' => 'home',
                'icon'=>'bx bxs-home'
            ],
            'BN Scholars' => [
                'link' => 'attendance.php',
                'key' => 'attendance',
                // 'imageIcon' => '../assets/images/clipboard-list-dark.png'
                'icon' => 'bx bxs-notepad'
            ],
            'BN Scholar Activities' => [
                'link' => 'activities.php',
                'key' => 'activities',
                'icon'=>'bx bxs-note'
            ],
           
        ];
        ?>
        <?php foreach ($navItems as $name => $navItem) : ?>
            <li class="nav-item mb-4 <?= $current_page == $navItem['key'] ? 'active' : '' ?>">
                <a href="<?= $navItem['link'] ?>" class="nav-link link-secondary justify-content-center d-flex align-items-center">
                    <?php if(isset($navItem['imageIcon'])): ?>
                        <img src="<?= $navItem['imageIcon'] ?>" class="mx-auto" alt="">
                    <?php else: ?>
                        <i class="fs-4 my-0 <?= $navItem['icon'] ?>"></i>
                    <?php endif ?>
                    <!-- <span class="ms-3"><?= $name ?></span> -->
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>

<div class="sidebar-overlay-sm" id="sidebar-overlay"></div>
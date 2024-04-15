<?php
if (!empty($admin['image'])) {
?>
    <div id="profile-pic-div" class="image-div <?= $profile_pic_size ?? 'lg' ?>" data-image="../../assets/images/<?= $admin['image'] ?>"></div>
<?php
} else {
?>
    <div class="text-profile-pic photo <?= $profile_pic_size ?? 'lg' ?> bg-light-brown border-light border-2 border text-dark shadow-sm">
        <div class="text fw-normal">
            <?= $admin['firstname'][0] .  $admin['lastname'][0] ?>
        </div>
    </div>
<?php
}
?>  
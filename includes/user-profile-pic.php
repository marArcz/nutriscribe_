<?php
if (!empty($user['photo'])) {
?>
    <div id="profile-pic-div" class="image-div <?= $profile_pic_size ?? 'lg' ?>" data-image="../assets/images/<?= $user['photo'] ?>"></div>
<?php
} else {
?>
    <div class="text-profile-pic photo <?= $profile_pic_size ?? 'lg' ?> bg-secondary border-light border-2 border text-light ">
        <div class="text fw-normal">
            <?= $user['firstname'][0] .  $user['lastname'][0] ?>
        </div>
    </div>
<?php
}
?>
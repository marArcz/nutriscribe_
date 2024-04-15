<div class="modal fade" id="photo-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-6 fw-medium" id="exampleModalLabel">Profile Picture</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" action="" method="post">
                <div class="modal-body">
                    <div class="picture-wrapper text-center">
                        <div id="modal-profile-pic-div" class="image-div lg mx-auto <?= !isset($admin['image']) ? 'd-none' : '' ?>" data-image="../assets/images/<?= isset($admin['image']) ? $admin['image'] : '' ?>"></div>
                        <div id="text-profile-pic" class="text-profile-pic <?= isset($admin['image']) ? 'd-none' : '' ?> mx-auto photo lg bg-secondary border-light border-3 border text-light ">
                            <div class="text fw-normal">
                                <?= $user['firstname'][0] .  $user['lastname'][0] ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <label class="btn btn-light-dark" for="profile-pic-input">Select photo</label>
                        <input type="file" id="profile-pic-input" class="d-none" name="photo">
                    </div>
                </div>
                <div class="modal-footer justify-between d-flex">
                    <button type="button" class="btn btn-light-dark fw-medium" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="change_photo" class="btn btn-light-green fw-medium ms-auto">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
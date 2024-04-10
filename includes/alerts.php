<?php if (Session::hasSession('success')) : ?>
    <div class="alert bg-green-accent bg-opacity-75 shadow-sm fw-normal py-2 rounded-0 alert-dismissible fade show d-flex align-items-center" role="alert">
        <i class='bx bxs-check-circle bx-sm text-white me-3'></i>
        <span class="text-white"><?= Session::getSuccess() ?></span>
        <button type="button" class="btn btn-sm my-0 ms-auto" data-bs-dismiss="alert" aria-label="Close">
            <i class="bx bx-x bx-sm text-white"></i>
        </button>
    </div>
<?php endif ?>
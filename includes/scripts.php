<script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- <script src="../../node_modules/jquery/dist/jquery.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>

<script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="../node_modules/datatables.net/js/jquery.dataTables.js"></script>
<script src="../node_modules/chart.js/dist/chart.umd.js"></script>
<script>
    <?php
    if (Session::hasSession('success')) {
    ?>
        Swal.fire(
            'Success',
            `<?= Session::getSuccess() ?>`,
            'success'
        )
    <?php
    } else if (Session::hasSession('error')) {
    ?>
        Swal.fire(
            'Error',
            `<?= Session::getError() ?>`,
            'error'
        )
    <?php
    }
    ?>
    const loadImageDivs = () => {
        $(".image-div").each(function(i, elem) {
            $(elem).css("background-image", `url('${$(elem).data('image')}')`)
        })
    }

    $(function() {
        loadImageDivs();
        $("#menu-toggler").on("click", function(e) {
            $("#sidebar").toggleClass("closed")
            // $("#main").toggleClass("expanded")
            $("#sidebar-overlay").toggleClass("show")
        })

        $("#sidebar-overlay").on('click', function(e) {
            $("#sidebar").addClass("closed")
            $("#sidebar-overlay").removeClass("show")
        })

        let lastActiveTime = Date.now() / 1000;

        document.addEventListener('mousemove', () => {
            lastActiveTime = Date.now() / 1000;
        });

        document.addEventListener('keydown', () => {
            lastActiveTime = Date.now() / 1000;
        });

        setInterval(() => {
            $.ajax({
                url: '../app/update_scholar_status.php',
                method: "POST",
                dataType: "json",
                data: {
                    lastActiveTime
                },
                success: function(res) {
                    console.log(res)
                },
                error: (err => console.error('error updating status: ', err))
            })
        }, 10000)
    })
</script>
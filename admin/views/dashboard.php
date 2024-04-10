<?php require_once '../includes/authenticated.php' ?>
<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">

    <?php
    $current_page = 'dashboard';
    require_once '../includes/sidebar.php'
    ?>
    <main id="main" class="dashboard <?= Session::hasSession("closed_sidebar") ? 'expanded' : '' ?>">
        <?php $header_title = 'Dashboard'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid-sm">
                <div class="container-fluid mb-3">
                    <div class="d-flex">
                        <h5 class="text-secondary fw-medium">Dashboard</h6>
                    </div>
                    <p class="fw-normal fs-6 mt-3 text-green-accent">Attendance</p>
                    <div class="row gy-5">
                        <div class="col-md-5 mb-2">
                            <div class="d-flex align-items-center">
                                <span class="bullet bg-green-accent me-2 rounded-circle"></span>
                                <p class="text-green-accent fw-medium my-0">
                                    <small>Today</small>
                                </p>
                            </div>
                            <!-- header -->
                            <div class="attendance-wrapper">
                                <div class="row mt-3 gx-1 mb-1">
                                    <div class="col-3">
                                        <div class="p-2 text-white bg-dark-brown text-center">
                                            <i class="bx bxs-group"></i>
                                            <p class="fw-normal mb-0"><small>BN Scholar</small></p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 text-white bg-light-danger text-center">
                                            <i class="bx bx-time"></i>
                                            <p class=" mb-0"><small class="fw-medium">Time In</small></p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 text-white bg-light-purple text-center">
                                            <i class="bx bx-time"></i>
                                            <p class=" mb-0"><small class="fw-medium">Time Out</small></p>
                                        </div>
                                    </div>
                                </div>
                                <div id="attendance-wrapper">
                                    <div class="row gx-1 mb-1">
                                        <div class="col-3">
                                            <div class="bg-light border p-2 text-center">
                                                <p class="placeholder-glow my-1 ">
                                                    <img src="../../assets/images/grey.jpg" class="img-fluid placeholder border border-2 rounded-circle shadow-sm" width="37" alt="">
                                                    <span class="placeholder placeholder-xs bg-secondary rounded col-9"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="bg-light border p-2 text-center h-100 d-flex justify-content-center align-items-center">
                                                <p class="placeholder-glow my-1 w-100">
                                                    <span class="placeholder placeholder-xs bg-secondary rounded col-7"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="bg-light border p-2 text-center h-100 d-flex justify-content-center align-items-center">
                                                <p class="placeholder-glow my-1 w-100">
                                                    <span class="placeholder placeholder-xs bg-secondary rounded col-7"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gx-1 mb-1">
                                        <div class="col-3">
                                            <div class="bg-light border p-2 text-center">
                                                <p class="placeholder-glow my-1 ">
                                                    <img src="../../assets/images/grey.jpg" class="img-fluid placeholder border border-2 rounded-circle shadow-sm" width="37" alt="">
                                                    <span class="placeholder placeholder-xs bg-secondary rounded col-9"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="bg-light border p-2 text-center h-100 d-flex justify-content-center align-items-center">
                                                <p class="placeholder-glow my-1 w-100">
                                                    <span class="placeholder placeholder-xs bg-secondary rounded col-7"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="bg-light border p-2 text-center h-100 d-flex justify-content-center align-items-center">
                                                <p class="placeholder-glow my-1 w-100">
                                                    <span class="placeholder placeholder-xs bg-secondary rounded col-7"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="d-flex align-items-center">
                                <span class="bullet bg-purple me-2 rounded-circle"></span>
                                <p class="text-purple fw-medium my-0">
                                    <small>Summary</small>
                                </p>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <div class="d-flex mt-3 gap-1">
                                        <button id="btn-monthly-chart" class="btn border-0 btn-secondary btn-sm rounded-pill px-3">
                                            <small class="">Monthly</small>
                                        </button>
                                        <button id="btn-scholar-chart" class="btn border-0 btn-outline-secondary btn-sm rounded-pill px-3">
                                            <small class="">Scholar</small>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="float-end">
                                        <!-- dropdown -->
                                        <div>
                                            <select name="" id="year-dropdown" class="text-sm border-0 text-green select-borderless">
                                                <option value="2023">Year 2023</option>
                                                <option value="2022">Year 2022</option>
                                                <option value="2021">Year 2021</option>
                                            </select>
                                            <select name="" id="scholar-dropdown" class="d-none text-sm border-0 text-green select-borderless">
                                                <option value="1">John Doe</option>
                                                <option value="2">John Doe</option>
                                                <option value="3">John Doe</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- chart -->
                            <div class="container-fluid mt-3">
                                <canvas id="monthly-chart"></canvas>
                                <canvas id="scholar-chart" class="d-none"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
    <script>
        const monthlyChartCtx = document.getElementById('monthly-chart');
        const scholarChartCtx = document.getElementById('scholar-chart');
        const colors = {
            purpleAccent: '#dcc2f4',
            lightGreen: '#9fd3b2',
            lightBrown: '#f4d4c2',
            lightGreenAccent: '#9fd3ca'
        }
        const monthlyChart = new Chart(monthlyChartCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                        label: 'Total Attendance',
                        data: [22, 8, 12, 19],
                        borderWidth: 1,
                        backgroundColor: colors.purpleAccent,
                        borderRadius: 4,
                        borderSkipped: false,
                        borderColor: colors.purpleAccent,
                    },
                    {
                        label: 'Total Absence',
                        data: [3, 12, 8, 7],
                        borderWidth: 1,
                        backgroundColor: colors.lightGreen,
                        borderRadius: 4,
                        borderSkipped: false
                    }

                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            // This more specific font property overrides the global property
                            font: {
                                family: 'Outfit'
                            }
                        }
                    }
                }
            }
        });

        const scholarChart = new Chart(scholarChartCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                        label: 'Total Attendance',
                        data: [22, 8, 12, 19],
                        borderWidth: 1,
                        backgroundColor: colors.lightBrown,
                        borderRadius: 4,
                        borderSkipped: false
                    },
                    {
                        label: 'Total Absence',
                        data: [3, 12, 8, 7],
                        borderWidth: 1,
                        backgroundColor: colors.lightGreenAccent,
                        borderRadius: 4,
                        borderSkipped: false
                    }

                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            // This more specific font property overrides the global property
                            font: {
                                family: 'Outfit'
                            }
                        }
                    }
                }
            }
        });

        $("#btn-scholar-chart").on("click", function() {
            $(this).removeClass('btn-outline-secondary').addClass('btn-secondary')
            $("#btn-monthly-chart").removeClass('btn-secondary').addClass('btn-outline-secondary')

            $("#year-dropdown").addClass('d-none')
            $("#scholar-dropdown").removeClass('d-none')

            $("#monthly-chart").addClass('d-none')
            $("#scholar-chart").removeClass('d-none')

        })
        $("#btn-monthly-chart").on("click", function() {
            $(this).removeClass('btn-outline-secondary').addClass('btn-secondary')
            $("#btn-scholar-chart").removeClass('btn-secondary').addClass('btn-outline-secondary')

            $("#scholar-dropdown").addClass('d-none')
            $("#year-dropdown").removeClass('d-none')

            $("#scholar-chart").addClass('d-none')
            $("#monthly-chart").removeClass('d-none')
        })


        function attendanceRow(data) {
            return `<div class="row gx-1 mb-1">
                    <div class="col-3">
                        <div class="bg-light border p-2 text-center">
                        <div id="profile-pic-div" class="image-div sm mx-auto" data-image="../../assets/images/${data.photo}"></div>
                            <p class="my-1">
                                <small>${data.name}</small>
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-light border p-2 text-center h-100 d-flex justify-content-center align-items-center">
                            <small class="fw-medium">${data.time_in || 'None'}</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="bg-light border p-2 text-center h-100 d-flex justify-content-center align-items-center">
                            <small class="fw-medium">${data.time_out || 'None'}</small>
                        </div>
                    </div>
                </div>`;
        }

        const loadProfilePhotos = () => {
            $(".image-div").each((i,elem) => {
                $(elem).css("background-image",`url('${$(elem).data('image')}')`);
            })
        }

        var attendanceData = '';
        const getAttendance = () => {
            $.ajax({
                url: '../app/get_attendances.php',
                method: 'post',
                dataType: 'json',
                success: function(res) {
                    if (JSON.stringify(res) != attendanceData) {
                        console.log(res);
                        attendanceData = JSON.stringify(res);

                        $("#attendance-wrapper").html('');
                        for (let data of res) {
                            let row = attendanceRow(data);
                            $("#attendance-wrapper").append(row);
                            loadProfilePhotos();
                        }
                    }
                },
                error: (err => console.log(err))
            })
        }

        $(function() {
            setInterval(getAttendance, 1000)
        })
    </script>
</body>

</html>
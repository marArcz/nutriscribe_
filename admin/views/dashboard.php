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
                                        <div class="p-2 h-100 align-items-center d-flex flex-column justify-content-center align-items-center text-white bg-dark-brown text-center">
                                            <i class="bx bxs-group"></i>
                                            <p class="fw-normal mb-0"><small>BN Scholar</small></p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 h-100 align-items-center d-flex flex-column justify-content-center align-items-center text-white bg-light-danger text-center">
                                            <i class="bx bx-time"></i>
                                            <p class=" mb-0"><small class="fw-medium">Time In</small></p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="p-2 h-100 align-items-center d-flex flex-column justify-content-center align-items-center text-white bg-light-purple text-center">
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
                        <div class="col-md-7">
                            <div class="d-flex align-items-center">
                                <span class="bullet bg-purple me-2 rounded-circle"></span>
                                <p class="text-purple fw-medium my-0">
                                    <small>Monthly Summary</small>
                                </p>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <div class="d-flex mt-3 gap-1">
                                        <button id="btn-attendance-chart" class="btn border-0 btn-secondary btn-sm rounded-pill px-3">
                                            <small class="">Attendances</small>
                                        </button>
                                        <button id="btn-activities-chart" class="btn border-0 btn-outline-secondary btn-sm rounded-pill px-3">
                                            <small class="">Activities</small>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="float-end">
                                        <!-- dropdown -->
                                        <div>
                                            <select name="" id="attendance-year-dropdown" class="text-sm border-0 text-green select-borderless">
                                                <?php
                                                // get the lowest year from attendance record
                                                $query = $pdo->query("SELECT MIN(YEAR(created_at)) FROM attendances");
                                                $lowest_year = $query->fetch()[0];
                                                $current_year = date('Y');

                                                for ($year = $lowest_year; $year <= $current_year; $year++) {
                                                ?>
                                                    <option value="<?= $year ?>">Year <?= $year ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <select name="" id="activities-year-dropdown" class="d-none text-sm border-0 text-green select-borderless">
                                                <?php
                                                for ($year = $lowest_year; $year <= $current_year; $year++) {
                                                ?>
                                                    <option value="<?= $year ?>">Year <?= $year ?></option>
                                                <?php
                                                }
                                                ?>
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
                    <!-- activities -->
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <span class="bullet bg-gray2 me-2 rounded-circle"></span>
                        <p class="text-gray2 fw-medium my-0">
                            <small>This Week's Activities</small>
                        </p>
                    </div>
                    <div class="table-responsive-sm ">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Project / Task</th>
                                    <th>BN Scholar</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $pdo->prepare("SELECT scholar_activities.*,scholar_infos.firstname,scholar_infos.middlename,scholar_infos.lastname FROM scholar_activities INNER JOIN scholar_infos ON scholar_activities.scholar_id = scholar_infos.id WHERE YEARWEEK(scholar_activities.created_at,1) = YEARWEEK(NOW(),1) LIMIT 5");
                                $query->execute();
                                while ($row = $query->fetch()) {
                                ?>
                                    <tr>
                                        <td><?= $row['title'] ?></td>
                                        <td><?= $row['firstname'] ?> <?= $row['middlename'] ?> <?= $row['lastname'] ?></td>
                                        <td><?= $row['location'] ?></td>
                                        <td><?= date('M d, Y', strtotime($row['date'])) ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php if ($query->rowCount() == 0) : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nothing to show.</td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($query->rowCount() > 5) : ?>

                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require_once '../includes/scripts.php' ?>
    <script>
        const monthlyChartCtx = document.getElementById('monthly-chart');
        const activitiesChartCtx = document.getElementById('scholar-chart');
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
                    data: [],
                    borderWidth: 1,
                    backgroundColor: colors.purpleAccent,
                    borderRadius: 4,
                    borderSkipped: false,
                    borderColor: colors.purpleAccent,
                }, ],
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

        const activitiesChart = new Chart(activitiesChartCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Total Activities',
                    data: [22, 8, 12, 19],
                    borderWidth: 1,
                    backgroundColor: colors.lightBrown,
                    borderRadius: 4,
                    borderSkipped: false
                }, ],
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



        var monthlyChartData = "";
        const loadAttendanceChartData = () => {
            $.ajax({
                url: "../app/all-attendances.php",
                method: 'post',
                data: {
                    year: $("#attendance-year-dropdown").val()
                },
                dataType: 'json',
                success: (data) => {
                    console.log('monthly data: ', data);
                    const currentMonth = new Date().getMonth();
                    const dataSet = [];
                    for (let m = 0; m <= currentMonth; m++) {
                        dataSet.push(data[m]);
                    }
                    // const dataSet = data.map((elem,i) => {elem})
                    monthlyChart.data.datasets[0].data = dataSet;
                    monthlyChart.update();
                },
                error: (err => console.error("loading monthly chart: ", err))
            })
        }
        loadAttendanceChartData();

        const loadActivitiesChartData = () => {
            $.ajax({
                url: "../app/activities-chart-data.php",
                method: 'post',
                data: {
                    year: $("#activities-year-dropdown").val()
                },
                dataType: 'json',
                success: (data) => {
                    console.log('activities chart data: ', data);
                    const currentMonth = new Date().getMonth();
                    const dataSet = [];
                    for (let m = 0; m <= currentMonth; m++) {
                        dataSet.push(data[m]);
                    }
                    // const dataSet = data.map((elem,i) => {elem})
                    activitiesChart.data.datasets[0].data = dataSet;
                    activitiesChart.update();
                },
                error: (err => console.error("loading activities chart: ", err))
            })
        }
        loadActivitiesChartData();

        $("#attendance-year-dropdown").on("change", (e) => loadAttendanceChartData());

        $("#btn-activities-chart").on("click", function() {
            $(this).removeClass('btn-outline-secondary').addClass('btn-secondary')
            $("#btn-attendance-chart").removeClass('btn-secondary').addClass('btn-outline-secondary')

            $("#attendance-year-dropdown").addClass('d-none')
            $("#activities-year-dropdown").removeClass('d-none')

            $("#monthly-chart").addClass('d-none')
            $("#scholar-chart").removeClass('d-none')

        })
        $("#btn-attendance-chart").on("click", function() {
            $(this).removeClass('btn-outline-secondary').addClass('btn-secondary')
            $("#btn-activities-chart").removeClass('btn-secondary').addClass('btn-outline-secondary')

            $("#activities-year-dropdown").addClass('d-none')
            $("#attendance-year-dropdown").removeClass('d-none')

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
            $(".image-div").each((i, elem) => {
                $(elem).css("background-image", `url('${$(elem).data('image')}')`);
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

                        if (res.length == 0) {
                            let elem = `<div class='text-center border py-2'>
                                <p class="text-gray2 text-sm my-0">Nothing to show.</p>
                            </div>`;

                            $("#attendance-wrapper").append(elem);
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
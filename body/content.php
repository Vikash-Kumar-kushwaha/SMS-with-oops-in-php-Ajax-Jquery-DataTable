<div class="container " id="main">
    <div class="body-content">
        <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div data-addstud="topDiv"
                class="addstud shadow p-3 my-2 bg-white rounded bg-body shadow d-flex align-items-center justify-content-between">
                <div class="input-group" style="width:20rem">
                    <input type="text" id="searchInput" class="form-control" placeholder="">
                    <span class="input-group-text">Search</span>
                </div>
                <h3 class="student-info text-center text-info" style="cursor:pointer;">Slide Up</h3>
                <div class="dropdown" style="left:11rem">
                    <button class="btn btn-body dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Department
                    </button>
                    <ul class="dropdown-menu p-0">
                        <li class=""><a class="text-dark text-decoration-none fs-6" href="#" data-dept="1">CSE</a></li>
                        <li class=""><a class="text-dark text-decoration-none fs-6" href="#" data-dept="3">MECH</a></li>
                        <li class=""><a class="text-dark text-decoration-none fs-6" href="#" data-dept="2">IT</a></li>
                        <li class=""><a class="text-dark text-decoration-none fs-6" href="#" data-dept="4">AGRI</a></li>
                    </ul>
                </div>
                <!-- <div class="text-center flex-grow-1  fs-4">Student information</div> -->
                <button class="btn btn-info addNewStudent">
                    <a class="text-decoration-none text-white" href="javascript:void(0)">Add New
                        Student</a>
                </button>
            </div>
        <?php endif; ?>

        <table class="display" id="myTable">
            <thead>

                <th scope="col" data-column="studid">Stud.id</th>
                <th scope="col" data-column="StudName">StudName</th>
                <th class="" scope="col">email</th>
                <th class="" scope="col">fatherName</th>
                <th class="" scope="col">Date Of Birth</th>
                <th class="" scope="col">Dept</th>
                <th scope="col">uploadfile</th>
                <th scope="col">View</th>
                <th scope="col">Operations</th>

            </thead>
            <tbody data-table="table-data">
            </tbody>
        </table>

    </div>
</div>
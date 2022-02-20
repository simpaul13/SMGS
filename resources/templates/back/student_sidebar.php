<nav id="sidebar">
    <div class="sidebar-header">
        <h3>School Management System</h3>
        <strong>SMG</strong>
    </div>

    <ul class="list-unstyled components">
        <li>
            <a href="index.php">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>
        <!-- Class -->
        <li>
            <a href="#class" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" aria-haspopup="true">
                <i class="fas fa-list-alt"></i>
                Class
            </a>
            <ul class="collapse list-unstyled" id="class">
                <li>
                    <a href="index.php?class">
                        <i class="fas fa-list"></i>
                        View Class
                    </a>
                </li>
                <li>
                    <a href="index.php?add_class">
                        <i class="fas fa-file-medical"></i>
                        Add Class
                    </a>
                </li>
                <!-- Teacher Class  -->
                <li>
                    <a href="#teacherclass" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-user-tie"></i>
                        Teacher Class
                    </a>
                    <ul class="collapse list-unstyled" id="teacherclass">
                        <li>
                            <a href="index.php?teacherclass">
                                <i class="fas fa-list"></i>
                                View Teacher Class
                            </a>
                        </li>
                        <li>
                            <a href="index.php?add_teacherclass">
                                <i class="fas fa-user-plus"></i>
                                Add Teacher Class
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Teacher Class End -->
                <!-- Student Classes -->
                <li>
                    <a href="#studentclass" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-users"></i>
                        Student Class
                    </a>
                    <ul class="collapse list-unstyled" id="studentclass">
                        <li>
                            <a href="index.php?studentclass">
                                <i class="fas fa-list"></i>
                                View Student Class
                            </a>
                        </li>
                        <li>
                            <a href="index.php?add_studentclass">
                                <i class="fas fa-user-plus"></i>
                                Add Student Class
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Student Classes End -->
            </ul>
        </li>
        <!-- Class End -->

    </ul>
</nav>

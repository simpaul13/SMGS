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
        <!-- Student And Teacher List -->
        <li>
            <a href="#persion" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" aria-haspopup="true">
                <i class="fas fa-user-friends"></i>
                Student & Teacher
            </a>
            <ul class="collapse list-unstyled" id="persion">
                <li>
                    <a href="index.php?student">
                        <i class="fas fa-users-class"></i>
                        Student
                    </a>
                </li>
                <li>
                    <a href="index.php?teacher">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Teacher
                    </a>
                </li>
            </ul>
        </li>
        <!-- Student And Teacher List End-->
        <!-- Schedule -->
        <li>
            <a href="#schedule" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"
                aria-haspopup="true">
                <i class="fas fa-list-alt"></i>
                Schedule
            </a>
            <ul class="collapse list-unstyled" id="schedule">
                <li>
                    <a href="index.php?classroom">
                        <i class="far fa-users-class"></i>
                        Classroom
                    </a>
                </li>
                <li>
                    <a href="index.php?section">
                        <i class="fas fa-list"></i>
                        Section
                    </a>
                </li>
                <li>
                    <a href="index.php?subject">
                        <i class="fal fa-books"></i>
                        Subject
                    </a>
                </li>
                <li>
                    <a href="index.php?schedule">
                        <i class="fal fa-calendar-alt"></i>
                        Schedule
                    </a>
                </li>
            </ul>
        </li>
        <!-- Schedule End -->
    </ul>
</nav>

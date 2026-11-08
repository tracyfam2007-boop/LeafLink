<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="admin-sidebar">

    <ul>

        <li>
            <a href="/LeafLink/admin/dashboard.php"
                class="<?= ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="/LeafLink/admin/users/manage_user.php"
                class="<?= ($currentPage == 'manage_user.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-users"></i>
                <span>Manage Users</span>
            </a>
        </li>

        <li>
            <a href="/LeafLink/admin/activities/manage_activity.php"
                class="<?= ($currentPage == 'manage_activity.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-leaf"></i>
                <span>Manage Activities</span>
            </a>
        </li>

        <li>
            <a href="/LeafLink/admin/rewards/manage_reward.php"
                class="<?= ($currentPage == 'manage_reward.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-gift"></i>
                <span>Manage Rewards</span>
            </a>
        </li>

        <li>
            <a href="/LeafLink/admin/badges/manage_badge.php"
                class="<?= ($currentPage == 'manage_badge.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-award"></i>
                <span>Manage Badges</span>
            </a>
        </li>

        <li>
            <a href="/LeafLink/admin/team_challenge/manage_teamchallenge.php"
                class="<?= ($currentPage == 'manage_teamchallenge.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-people-group"></i>
                <span>Team Challenges</span>
            </a>
        </li>

        <li>
            <a href="/LeafLink/admin/reports/manage_report.php"
                class="<?= ($currentPage == 'manage_report.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-chart-simple"></i>
                <span>Reports</span>
            </a>
        </li>

        <li>
            <a href="#" class="sidebar-link" onclick="showLogoutModal(event)">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

</aside>

<div id="logoutModal" class="logout-modal">

    <div class="logout-modal-content">

        <div class="logout-icon">
            <i class="fa-solid fa-right-from-bracket"></i>
        </div>

        <h2>Confirm Logout</h2>

        <p>Please confirm if you would like to log out from LeafLink.</p>

        <div class="logout-modal-buttons">
            <button
                type="button"
                class="logout-cancel-btn"
                onclick="closeLogoutModal()">
                Cancel
            </button>

            <button
                type="button"
                class="logout-confirm-btn"
                onclick="confirmLogout()">
                Logout
            </button>
        </div>

    </div>

</div>

<script>
    function showLogoutModal(event) {
        event.preventDefault();
        document.getElementById("logoutModal").style.display = "flex";
    }

    function closeLogoutModal() {
        document.getElementById("logoutModal").style.display = "none";
    }

    function confirmLogout() {
        window.location.href = "/LeafLink/admin/logout.php";
    }
</script>
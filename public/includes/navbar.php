<?php  
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    header("location: index.php");
    exit();
}

$pageScript = basename($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF']);
$userId = $_SESSION["id"];
$userInfo = userManager::getUserByID($userId);
if (!$userInfo) {
    session_destroy();
    header("location: index.php");
    exit();
}

$isAdmin = ($userInfo->is_admin == 1);
?>

<div class='navbar'>
    <div class="nav-left">
        <button type="button" class="menubtn" id="menuToggleBtn" title="Menu openen" aria-label="Menu openen">
            <svg class="hamburger-icon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>

    <p class="nav-title"><a href="<?= $isAdmin ? 'mainscreen-admin.php' : 'mainscreen-employee.php' ?>">Warehouse B.V</a></p>

    <div class="nav-right-spacer"></div>
</div>

<!-- Achtergrond overlay -->
<div class="slideout-backdrop" id="slideoutBackdrop"></div>

<!-- Slide-out Menu aan de linkerkant -->
<div class="slideout-drawer" id="slideoutDrawer">
    <div class="drawer-header">
        <div class="drawer-user">
            <img class="drawer-pfp" src="profile-picture.php?id=<?= $userInfo->id ?>" alt="Profielfoto">
            <div class="drawer-user-info">
                <span class="drawer-username"><?= htmlspecialchars($userInfo->username) ?></span>
                <span class="drawer-role"><?= $isAdmin ? 'Admin' : 'Medewerker' ?></span>
            </div>
        </div>
        <button type="button" class="drawer-close-btn" id="drawerCloseBtn" title="Menu sluiten" aria-label="Menu sluiten">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="drawer-menu">
        <?php if ($isAdmin): ?>
            <div class="drawer-category">Producten</div>
            <a class="drawer-link <?= ($pageScript === 'mainscreen-admin.php') ? 'active' : '' ?>" href="mainscreen-admin.php">Producten overzicht</a>
            <a class="drawer-link <?= ($pageScript === 'addProduct.php') ? 'active' : '' ?>" href="addProduct.php">Product toevoegen</a>

            <div class="drawer-category">Gebruikers</div>
            <a class="drawer-link <?= ($pageScript === 'userOverview.php') ? 'active' : '' ?>" href="userOverview.php">Gebruikers overzicht</a>
            <a class="drawer-link <?= ($pageScript === 'addUser.php') ? 'active' : '' ?>" href="addUser.php">Gebruiker toevoegen</a>

            <div class="drawer-category">Statistieken</div>
            <a class="drawer-link <?= ($pageScript === 'grafiek_info.php') ? 'active' : '' ?>" href="grafiek_info.php">Grafiek info bekijken</a>
        <?php else: ?>
            <div class="drawer-category">Voorraad</div>
            <a class="drawer-link <?= ($pageScript === 'mainscreen-employee.php') ? 'active' : '' ?>" href="mainscreen-employee.php">QR Scanner</a>
        <?php endif; ?>
    </div>

    <div class="drawer-footer">
        <a class="drawer-logout-btn" href="logout.php">afmelden</a>
    </div>
</div>

<script>
(function() {
    const toggleBtn = document.getElementById("menuToggleBtn");
    const drawer = document.getElementById("slideoutDrawer");
    const backdrop = document.getElementById("slideoutBackdrop");
    const closeBtn = document.getElementById("drawerCloseBtn");

    function openDrawer() {
        if (!drawer || !backdrop) return;
        drawer.classList.add("open");
        backdrop.classList.add("open");
    }

    function closeDrawer() {
        if (!drawer || !backdrop) return;
        drawer.classList.remove("open");
        backdrop.classList.remove("open");
    }

    if (toggleBtn) toggleBtn.addEventListener("click", openDrawer);
    if (closeBtn) closeBtn.addEventListener("click", closeDrawer);
    if (backdrop) backdrop.addEventListener("click", closeDrawer);

    window.addEventListener("keydown", function(e) {
        if (e.key === "Escape" && drawer && drawer.classList.contains("open")) {
            closeDrawer();
        }
    });
})();
</script>

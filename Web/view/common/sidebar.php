<nav class="flex flex-col bg-blue-700 p-0">
    <i class="fa-solid fa-house btn-sidebar" title="Dashboard" onclick="window.location = '/'"></i>
    <?php if ($_SESSION['role'] == 1) { ?>
    <i class="fa-solid fa-cog btn-sidebar" title="Settings" onclick="window.location = '/settings'"></i>
    <i class="fa-solid fa-users btn-sidebar" title="Settings" onclick="window.location = '/users'"></i>
    <?php } ?>
    <span class="flex-grow"></span>
    <i class="fa-solid fa-right-from-bracket btn-sidebar" title="Log out" onclick="window.location = '/logout'"></i>
    <i class="fa-solid fa-lock btn-sidebar" title="Secured with AEAD Encryption"></i>
</nav>
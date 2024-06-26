<nav class="flex flex-col bg-blue-700 p-0">
    <i
        class="fa-solid fa-house btn-sidebar"
        title="Dashboard"
        role="button"
        tabIndex="0"
        onclick="window.location = '/'"
    ></i>
    <i
        class="fa-solid fa-cog btn-sidebar"
        title="Settings"
        role="button"
        tabIndex="0"
        onclick="window.location = '/settings'"
    ></i>
    <?php if ($_SESSION['role'] == 1) { ?>
    <i
        class="fa-solid fa-users btn-sidebar"
        title="Users"
        role="button"
        tabIndex="0"
        onclick="window.location = '/users'"
    ></i>
    <?php } ?>
    <span class="flex-grow"></span>
    <i
            class="fa-regular fa-circle-question btn-sidebar"
            onclick="window.open('https://github.com/lewmilburn/Vault/wiki/Vault-User-Guide', '_blank').focus();"
            title="View Help"
    ></i>
    <i
        class="fa-solid fa-right-from-bracket btn-sidebar"
        title="Log out"
        role="button"
        tabIndex="0"
        onclick="window.location = '/logout'"
    ></i>
    <i
        class="fa-solid fa-lock btn-sidebar"
        title="Secured with AEAD Encryption"
        role="button"
        tabIndex="0"
    ></i>
</nav>

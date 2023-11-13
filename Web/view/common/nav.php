<?php
use Vault\security\InputManager;
$im = new InputManager();
?><nav>
    <p class="self-center">Welcome back, <?= $im->escapeString($_SESSION['name']); ?></p>
    <div class="flex-grow"></div>
    <a class="btn-primary" href="/logout">Log out</a>
</nav>

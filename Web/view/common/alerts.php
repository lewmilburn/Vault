<?php if (ENV == DEV) { ?>
<div class="alert-red">
    Vault is in development mode.
    You should set ENV to PROD if you're running this in a production environment.
</div>
<?php } ?>
<?php if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") { ?>
    <div class="alert-red">
        You are using insecure HTTP. <a href="https://github.com/lewmilburn/Vault/wiki/Security#http-vs-https">Learn more here</a>.
    </div>
<?php } ?>
module.exports = function (electronApp) {
    if (!require(__dirname + '/fileExists')(require(__dirname + '/path')(electronApp, 'settings.json'))) {
        const {dialog} = require('electron');
        dialog.showErrorBox("Settings not found.","Creating...");
        const fs = require('fs');
        fs.writeFileSync(
            require(__dirname + '/path')(electronApp, 'settings.json'),
            '{"VAULT":{"SYNC_SERVER_URL":"https://localhost","ALLOW_OFFLINE_MODE":"true","FORCE_OFFLINE_MODE":"false"},"APP":{"WINDOW_WIDTH":"100%","WINDOW_HEIGHT":"100%","CACHE_ENCRYPTION_METHOD":"AES-256-GCM"}}'
        );
        if (!require(__dirname + '/fileExists')(require(__dirname + '/path')(electronApp, 'settings.json'))) {
            dialog.showErrorBox("Settings not found.", "Unable to create.");
        }
    }
}
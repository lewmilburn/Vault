let settings;

window.bridge.requestSettings(() => {});

window.bridge.sendSettings((event, vaultSettings) => {
    settings = vaultSettings;

    if (!document.getElementById('vault.sync_server_url') === null) {

        document.getElementById('vault.sync_server_url').value = settings.VAULT.SYNC_SERVER_URL;

        if (settings.VAULT.ALLOW_OFFLINE_MODE === "true") {
            document.getElementById('vault.allow_offline_mode').options[0].selected = true;
        } else {
            document.getElementById('vault.allow_offline_mode').options[1].selected = true;
        }

        if (settings.VAULT.FORCE_OFFLINE_MODE === "true") {
            document.getElementById('vault.force_offline_mode').options[0].selected = true;
        } else {
            document.getElementById('vault.force_offline_mode').options[1].selected = true;
        }

        document.getElementById('app.window_width').value = settings.APP.WINDOW_WIDTH;
        document.getElementById('app.window_height').value = settings.APP.WINDOW_HEIGHT;

        if (settings.APP.CACHE_ENCRYPTION_METHOD === "AES-256-GCM") {
            document.getElementById('app.cache_encryption_method').options[0].selected = true;
        }
    }
});

function screenDashboard() {
    window.bridge.screenDashboard(() => {});
}

function screenOffline() {
    window.bridge.screenOffline(() => {});
}

function screenLogin() {
    window.bridge.screenLogin(() => {});
}

function screenRestart() {
    window.bridge.screenRestart(() => {});
}

function screenMisconfiguration() {
    window.bridge.screenMisconfiguration(() => {});
}

function cacheUpdate(cache) {
    localStorage.setItem('cache', JSON.stringify(cache))
    window.bridge.updateCache(() => {});
}

function requestCache() {
    window.bridge.requestCache(() => {});
}

function requestUser() {
    window.bridge.requestUser(() => {});
}

function updateSettings() {
    window.bridge.updateSettings(() => {});
    screenRestart();
}

function reloadSettings() {
    window.bridge.fullReload(() => {});
    window.bridge.requestSettings(() => {});
}

function resync() {
    window.bridge.resync(() => {});
}

function shutdown() {
    window.bridge.shutdown(() => {});
}

function waitForSettings() {
    return new Promise((resolve) => {
        const settingsInterval = setInterval(() => {
            if (typeof settings !== 'undefined') {
                clearInterval(settingsInterval);
                resolve(settings);
            }
        }, 5);
    });
}
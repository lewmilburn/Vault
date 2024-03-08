let settings;

window.bridge.requestSettings(() => {});
window.bridge.sendSettings((event, vaultSettings) => {
    settings = vaultSettings;
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

function reloadSettings() {
    window.bridge.fullReload(() => {});
    window.bridge.requestSettings(() => {});
}

function resync() {
    window.bridge.resync(() => {});
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
function loadCache(override = false) {
    if ((localStorage.getItem('using-cache') === 'true' && settings.VAULT.ALLOW_OFFLINE_MODE) || override === true) {
        requestCache();

        window.bridge.recieveCache((event, cache) => {
            vault = JSON.parse(JSON.parse(cache)).data;
            displayPasswords();
        });
    }
}
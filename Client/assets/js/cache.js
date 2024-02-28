function loadCache() {
    if (localStorage.getItem('using-cache') === 'true' && settings.ALLOW_OFFLINE_MODE) {
        requestCache();

        window.bridge.recieveCache((event, cache) => {
            vault = JSON.parse(JSON.parse(cache)).data;
            displayPasswords();
        });
    }
}
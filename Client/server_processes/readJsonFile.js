module.exports = function (file) {
    let fs = require('fs');

    let json;

    try {
        json = JSON.parse(fs.readFileSync(file, 'utf-8'));
    } catch(error) {
        console.log('[VAULT] Failed to read JSON file "'+file+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+file+'" is readable and try again.');
    }

    return json;
}
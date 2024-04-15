const {join} = require("path");
module.exports = function (app, fileName) {
    let dev = false;
    if (dev) {
        return join(__dirname, fileName);
    } else {
        return join(app.getPath('userData'), fileName);
    }
}
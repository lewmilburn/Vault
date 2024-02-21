const crypto = require("crypto");
module.exports = function (data) {
    return crypto.createHash('sha512').update(data).digest("hex");
}